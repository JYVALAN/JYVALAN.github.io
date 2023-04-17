<?php
namespace Otopix\Repository;

use Otopix\Controller\AbstractController;
use Otopix\Manager\DbManager;
use Otopix\Model\Picture;

/**
 * Repository : classe visant à regrouper des fonctions de gestion (load/save)
 * "static" : mot-clé permettant de définir la fonction comme générique au référentiel
 */
final class PictureRepository extends AbstractRepository
{
    const TABLE = 'picture';
    const NB_ELTS_PER_PAGE = 3;

    /**
     * @param Picture $oPicture
     *
     * @return bool
     */
    public static function save(Picture $oPicture): bool
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'INSERT INTO `'. static::TABLE .'` (`user_id`, `category_id`, `title`, `description`, `picture`, `createdAt`)
            VALUES (:user_id, :category_id, :title, :description, :picture, :createdAt )';
        $oPdoStatement = $oPdo->prepare($sQuery);
        $oPdoStatement->bindValue(':user_id', $oPicture->getUser()->getId(), \PDO::PARAM_INT);
        $oPdoStatement->bindValue(':category_id', $oPicture->getCategory()->getId(), \PDO::PARAM_INT);
        $oPdoStatement->bindValue(':title', $oPicture->getTitle(), \PDO::PARAM_STR);
        $oPdoStatement->bindValue(':description', $oPicture->getDescription(), \PDO::PARAM_STR);
        $oPdoStatement->bindValue(':picture', $oPicture->getPicture(), \PDO::PARAM_STR);
        $oPdoStatement->bindValue(':createdAt', $oPicture->getCreatedAt()->format('Y-m-d H:i:s'), \PDO::PARAM_STR);

        return $oPdoStatement->execute();
    }

    /**
     * @return array
     */
    public static function findAll(): array
    {
        $oPdo = DbManager::getInstance();

        // Execution de la requête (query)
        $oPdoStatement = $oPdo->query('SELECT * FROM `'. static::TABLE .'` ORDER BY `createdAt` DESC');

        return static::extracted($oPdoStatement);
    }

    /**
     * @param array $aCriterias
     *
     * @return Picture[]
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
        return static::extracted($oPdoStatement);
    }

    /**
     * @param int $iId
     *
     * @return Picture|null
     * @throws \Exception
     */
    public static function find(int $iId): ?Picture
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
        return $aDbInfo ? static::hydrate($aDbInfo) : NULL;
    }

    /**
     * @param $aDbInfo
     *
     * @return Picture
     * @throws \Exception
     */
    protected static function hydrate(array $aDbInfo): Picture
    {
        $oCategoryPic = CategoryRepository::find($aDbInfo['category_id']);
        $oUserPic = UserRepository::find($aDbInfo['user_id']);

        // (1) création de l'objet
        $oPicture = new Picture(
            $aDbInfo['title'],
            $aDbInfo['description'],
            $oCategoryPic,
            $aDbInfo['picture'],
            $oUserPic
        );

        // >> (2) attribution des valeurs (concept d'hydratation)
        $oPicture->setId( $aDbInfo['id'] );
        $oPicture->setPicture( $aDbInfo['picture'] );
        $oPicture->setCreatedAt( new \DateTime($aDbInfo['createdAt'] ));

        return $oPicture;
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