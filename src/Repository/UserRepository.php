<?php
namespace Otopix\Repository;

use Otopix\Manager\DbManager;
use Otopix\Model\User;

/**
 * Repository : classe visant à regrouper des fonctions de gestion (load/save)
 * "static" : mot-clé permettant de définir la fonction comme générique au référentiel
 */
final class UserRepository extends AbstractRepository
{
    const TABLE = 'user';
    const NB_ELTS_PER_PAGE = 2;

    /**
     * @param string $email
     * @return bool
     */
    public static function isExist(string $email): bool
    {
        $oPdo = DbManager::getInstance();

        // Préparation et envoi de la ligne
        $sQuery = 'SELECT COUNT(*) AS nb FROM `'. static::TABLE .'` WHERE email = :email';

        // Utilisation des "requêtes préparées" pour se prémunir des injections SQL
        // -- On prépare la requête
        $oPdoStatement = $oPdo->prepare($sQuery);
        // -- On associe les paramètres
        $oPdoStatement->bindValue(':email', $email, \PDO::PARAM_STR);
        // -- On exécute la requête
        $oPdoStatement->execute();

        // On récupère le résultat
        $aDbInfo = $oPdoStatement->fetch(\PDO::FETCH_ASSOC);

        // S'il y a des lignes (nb > 0), alors l'utilisateur existe
        return ($aDbInfo['nb'] > 0);
    }

    /**
     * @return User[]
     */
    public static function findAll(): array
    {
        $oPdo = DbManager::getInstance();

        // Execution de la requête (query)
        $oPdoStatement = $oPdo->query('SELECT * FROM `'. static::TABLE .'`');

        // Parcours des résultats (while + fetch)
        return self::extracted($oPdoStatement);
    }

    /**
     * @param array $aCriterias
     *
     * @return User[]
     * @throws \Exception
     */
    public static function findBy(array $aCriterias, int $iOffset = 0, int $iNbElts = self::NB_ELTS_PER_PAGE): array
    {
        $oPdo = DbManager::getInstance();

        $aCriteriasInfo = static::buildCriterias($aCriterias);

        // -- Security
        if ($iOffset <= 0) {
            $iOffset = 0;
        }

        $sQuery = 'SELECT * FROM `'. static::TABLE .'`' . $aCriteriasInfo['where'];
        $sQuery .= ' LIMIT ' . implode(', ', [$iOffset, $iNbElts]);

        // Execution de la requête (query)
        $oPdoStatement = $oPdo->prepare($sQuery);
        $oPdoStatement->execute($aCriteriasInfo['params']);

        // Parcours des résultats (while + fetch)
        return self::extracted($oPdoStatement);
    }

    /** @inheritDoc */
    public static function find(int $iId): ?User
    {
        $oPdo = DbManager::getInstance();

        // Préparation de la requête
        $sQuery = 'SELECT * FROM `'. static::TABLE .'` WHERE id = :id';

        // Utilisation des "requêtes préparées" pour se prémunir des injections SQL
        // -- On prépare la requête
        $oPdoStatement = $oPdo->prepare($sQuery);
        // -- On associe les paramètres
        $oPdoStatement->bindValue(':id', $iId, \PDO::PARAM_INT);
        // -- On exécute la requête
        $oPdoStatement->execute();

        // Récupérer le bon utilisateur (tableau)
        $aDbInfo = $oPdoStatement->fetch();

        // On retourne soit l'objet hydraté, soit NULL
        return $aDbInfo ? self::hydrate($aDbInfo) : NULL;
    }

    /**
     * @param string $email
     * @return User|null
     */
    public static function findByEmail(string $email): ?User
    {
        $oPdo = DbManager::getInstance();

        //if (self::isExist($username)) {
        // Préparation de la requête pour récupérer mon utilisateur
        $sQuery = 'SELECT * FROM `'. static::TABLE .'` WHERE `email` = :email';

        // Utilisation des "requêtes préparées" pour se prémunir des injections SQL
        // -- On prépare la requête
        $oPdoStatement = $oPdo->prepare($sQuery);
        // -- On associe les paramètres
        $oPdoStatement->bindValue(':email', $email, \PDO::PARAM_STR);
        // -- On exécute la requête
        $oPdoStatement->execute();

        // Récupérer le bon utilisateur (tableau)
        $aDbInfo = $oPdoStatement->fetch();

        // On retourne soit l'objet hydraté, soit NULL
        return $aDbInfo ? self::hydrate($aDbInfo) : NULL;
    }

    /**
     * @param User $oUser
     *
     * @return bool
     */
    public static function save(User $oUser): bool
    {
        $oPdo = DbManager::getInstance();

        if ($oUser->getId()) {
            $sQuery = 'UPDATE `'. static::TABLE .'`
                    SET lastname = :lastname, firstname = :firstname, email = :email
                    WHERE id = :id';
            $oPdoStatement = $oPdo->prepare($sQuery);
            $oPdoStatement->bindValue(':id', $oUser->getId(), \PDO::PARAM_STR);
        } else {
            $sQuery = 'INSERT INTO ' . static::TABLE . ' (`lastname`, `firstname`, `email`, `password`, `user_picture`, `bio`, `role`, `createdAt`, `connectedAt`)
            VALUES (:lastname, :firstname, :email, :password, :user_picture, :bio, :role, :createdAt, :connectedAt)';
            $oPdoStatement = $oPdo->prepare($sQuery);
        }

        $oPdoStatement->bindValue(':lastname', $oUser->getLastname(), \PDO::PARAM_STR);
        $oPdoStatement->bindValue(':firstname', $oUser->getFirstname(), \PDO::PARAM_STR);
        $oPdoStatement->bindValue(':email', $oUser->getEmail(), \PDO::PARAM_STR);
        $oPdoStatement->bindValue(':password', $oUser->getPassword(), \PDO::PARAM_STR);
        $oPdoStatement->bindValue(':user_picture', $oUser->getUserPicture(), \PDO::PARAM_STR);
        $oPdoStatement->bindValue(':bio', $oUser->getBio(), \PDO::PARAM_STR);
        $oPdoStatement->bindValue(':role', $oUser->getRole(), \PDO::PARAM_INT);
        $oPdoStatement->bindValue(':createdAt', $oUser->getCreatedAt()->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
        $oPdoStatement->bindValue(':connectedAt', $oUser->getConnectedAt()->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
        
        return $oPdoStatement->execute();
    }

    /**
     * @param array $aDbInfo
     * @return User
     * @throws \Exception
     */
    protected static function hydrate(array $aDbInfo): User
    {
        // (1) création de l'objet
        $oUser = new User($aDbInfo['lastname'], $aDbInfo['firstname'], $aDbInfo['email'], $aDbInfo['password'], $aDbInfo['user_picture'], $aDbInfo['bio']);
     
        // >> (2) attribution des valeurs (concept d'hydratation)
        $oUser->setId($aDbInfo['id']);
        $oUser->setUserPicture($aDbInfo['user_picture']);
        $oUser->setBio($aDbInfo['bio']);
        $oUser->setRole($aDbInfo['role']);
        $oUser->setCreatedAt(new \DateTime($aDbInfo['createdAt']));
        $oUser->setConnectedAt(new \DateTime($aDbInfo['connectedAt']));

        return $oUser;
    }

    /**
     * @param array $aCriterias
     * @return array
     */
    protected static function buildCriterias(array $aCriterias): array
    {
        $aWhere = $aParams = [];

        // 1. Si "role" est défini (et non vide) dans mon tableau de critères ($aCriterias)
        if (!empty($aCriterias['role'])) {
            $aWhere[] = '(`role` = :role)';
            $aParams[':role'] = $aCriterias['role'];
        }

        // 2. Si "magic-search" est défini (et non vide) dans mon tableau de critères ($aCriterias)
        if (!empty($aCriterias['magic-search'])) {
            $aWhere[] = '((`lastname` LIKE :magicsearch) OR (`firstname` LIKE :magicsearch) OR (`email` LIKE :magicsearch))';
            $aParams[':magicsearch'] = '%'. $aCriterias['magic-search'] .'%';
        }

        // 3. Si "from" est défini (et non vide) dans mon tableau de critères ($aCriterias)
        if (!empty($aCriterias['from'])) {
            $aWhere[] = '(`createdAt` >= :from)';
            $aParams[':from'] = $aCriterias['from'] .' 00:00:00';
        }

        // 4. Si "to" est défini (et non vide) dans mon tableau de critères ($aCriterias)
        if (!empty($aCriterias['to'])) {
            $aWhere[] = '(`createdAt` <= :to)';
            $aParams[':to'] = $aCriterias['to'] .' 23:59:59';
        }

        $sWhere = '';
        if (count($aWhere) > 0) {
            // Si au moins un critère de recherche, on applique le WHERE et chaque condition (c1 AND c2 AND c3)
            $sWhere .= ' WHERE ' . implode(' AND ', $aWhere);
        }

        return [
            'where' => $sWhere,
            'params' => $aParams,
        ];
    }
}
