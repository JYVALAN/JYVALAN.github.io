<?php
namespace Otopix\Repository;

use Otopix\Manager\DbManager;
use Otopix\Model\Likes;
use Otopix\Model\User;


/**
 * Repository : classe visant à regrouper des fonctions de gestion (load/save)
 * "static" : mot-clé permettant de définir la fonction comme générique au référentiel
 */
final class LikesRepository extends AbstractRepository
{
    const TABLE = 'likes';
    const NB_ELTS_PER_PAGE = 20;

    /**
     * @return Likes[]
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
     * @return Likes[]
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
    public static function find(int $iId): ?Likes
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
     * @param Likes $oLikes
     *
     * @return bool
     */
    public static function save(Likes $oLikes): bool
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'INSERT INTO ' . static::TABLE . ' (`user_id`, `picture_id`, `createdAt`)
        VALUES (:user_id, :picture_id, :createdAt)';
        $oPdoStatement = $oPdo->prepare($sQuery);

            
        // $oPdoStatement->bindValue(':id', $oLikes->getId(), \PDO::PARAM_STR);
        // $oPdoStatement->bindValue(':user_id', $oLikes->getUser()->getId(), \PDO::PARAM_STR);
        // $oPdoStatement->bindValue(':picture_id', $oLikes->getPicture()->getId(), \PDO::PARAM_STR);
        // $oPdoStatement->bindValue(':createdAt', $oLikes->getCreatedAt()->format('Y-m-d H:i:s'), \PDO::PARAM_STR);

        
        // $oPdoStatement->bindValue(':id', $oLikes->getId(), \PDO::PARAM_STR);
        $oPdoStatement->bindValue(':user_id', $oLikes->getUserId(), \PDO::PARAM_STR);
        $oPdoStatement->bindValue(':picture_id', $oLikes->getPictureId(), \PDO::PARAM_STR);
        $oPdoStatement->bindValue(':createdAt', $oLikes->getCreatedAt()->format('Y-m-d H:i:s'), \PDO::PARAM_STR);

        return $oPdoStatement->execute();
    }

    /**
     * @param array $aDbInfo
     * @return Likes
     * @throws \Exception
     */
    protected static function hydrate(array $aDbInfo): Likes
    {

        $oPictureLike = PictureRepository::find($aDbInfo['picture_id']);
        $oUserLike = UserRepository::find($aDbInfo['user_id']);

        // (1) création de l'objet
        $oLikes = new Likes(
            $oPictureLike,
            $oUserLike

        );     
        // >> (2) attribution des valeurs (concept d'hydratation)
        $oLikes->setId($aDbInfo['id']);
        $oLikes->setPictureId($aDbInfo['picture_id']);
        $oLikes->setUserId($aDbInfo['user_id']);
        $oLikes->setCreatedAt(new \DateTime($aDbInfo['createdAt']));

        return $oLikes;
    }

        /**
     * @param array $aCriterias
     * @return array
     */
    protected static function buildCriterias(array $aCriterias): array
    {
        $aWhere = $aParams = [];

        // 1. Si "category" est défini (et non vide) dans mon tableau de critères ($aCriterias)
        if (!empty($aCriterias['category'])) {
            $aWhere[] = '(`category_id` = :category)';
            $aParams[':category'] = $aCriterias['category'];
        }

        // 2. Si "magic-search" est défini (et non vide) dans mon tableau de critères ($aCriterias)
        if (!empty($aCriterias['magic-search'])) {
            $aWhere[] = '((`title` LIKE :magicsearch)  OR (`description` LIKE :magicsearch))';
            $aParams[':magicsearch'] = '%'. $aCriterias['magic-search'] .'%';
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

     /**
     * @return string
     */
    public static function deleteLike(int $userId, int $pictureId): string
    {
        
        $oPdo = DbManager::getInstance();

        // Préparation de la requête
        $sQuery = 'DELETE FROM likes'.
            ' WHERE user_id = :user_id AND picture_id = :picture_id';

        // Utilisation des "requêtes préparées" pour se prémunir des injections SQL
        // -- On prépare la requête
        $oPdoStatement = $oPdo->prepare($sQuery);
        // -- On associe les paramètres
        $oPdoStatement->bindValue(':user_id', $userId, \PDO::PARAM_INT);
        $oPdoStatement->bindValue(':picture_id', $pictureId, \PDO::PARAM_INT);
        // -- On exécute la requête
        $executeIsOk = $oPdoStatement->execute();

        if($executeIsOk){
            $message = "L'image n'est plus dans vos favoris"; 
        }
        else{
            $message = 'Echec de la suppression du favori';
        }

        return $message;
    
    }

    public static function findLikeId()
    {     
        $oPdo = DbManager::getInstance();

        
        if(isset($_SESSION['user']) && $_SESSION['user'] instanceof User){
            $user = $_SESSION['user'];
            $userid = $user->getId();
        
        

        // Préparation de la requête
        $sQuery = 'SELECT * FROM likes'.
        ' WHERE user_id = :user_id';

        // Utilisation des "requêtes préparées" pour se prémunir des injections SQL
        // -- On prépare la requête
        $oPdoStatement = $oPdo->prepare($sQuery);
        // -- On associe les paramètres
        $oPdoStatement->bindValue(':user_id', $userid, \PDO::PARAM_INT);
        // -- On exécute la requête
        $oPdoStatement->execute();
        
        return static::extracted($oPdoStatement);
        }else{
            return null;
        }
    }
}
