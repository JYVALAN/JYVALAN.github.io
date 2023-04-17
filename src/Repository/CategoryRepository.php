<?php
namespace Otopix\Repository;

use Otopix\Manager\DbManager;
use Otopix\Model\Category;

/**
 * Repository : classe visant à regrouper des fonctions de gestion (load/save)
 * "static" : mot-clé permettant de définir la fonction comme générique au référentiel
 */
final class CategoryRepository extends AbstractRepository
{
    const TABLE = 'category';

    /**
     * @return Category[]
     */
    public static function findAll(): array
    {
        $oPdo = DbManager::getInstance();

        // Execution de la requête (query)
        $oPdoStatement = $oPdo->query('SELECT * FROM `'. static::TABLE .'`');

        return static::extracted($oPdoStatement);
    }

    /**
     * @return Category|null
     */
    public static function find(int $iId): ?Category
    {
        $oPdo = DbManager::getInstance();

        // Préparation de la requête
        $sQuery = 'SELECT * FROM `'. static::TABLE .'` WHERE id = :id';

        // Utilisation des "requêtes préparées" pour se prémunir des injections SQL
        $oPdoStatement = $oPdo->prepare($sQuery);
        $oPdoStatement->bindValue(':id', $iId, \PDO::PARAM_INT);
        $oPdoStatement->execute();

        // Récupérer le bon utilisateur (tableau)
        $aDbCategory = $oPdoStatement->fetch();

        return $aDbCategory ? static::hydrate($aDbCategory) : NULL;
    }

    /**
     * @param array $aDbInfo
     * @return Category
     */
    protected static function hydrate(array $aDbInfo): Category
    {
        // (1) création de l'objet
        $oCategory = new Category( $aDbInfo['name'] );

        // >> (2) attribution des valeurs (concept d'hydratation)
        $oCategory->setId( $aDbInfo['id'] );

        return $oCategory;
    }

    /**
     * @param array $aCriterias
     * @return array
     */
    public static function findBy(array $aCriterias, int $iOffset = 0, int $iNbElts = self::NB_ELTS_PER_PAGE): array
    {
        $oPdo = DbManager::getInstance();

        $sQuery = 'SELECT * FROM `'. static::TABLE .'`';

        $aWhere = $aParams = [];

        // 2. Si "magic-search" est défini (et non vide) dans mon tableau de critères ($aCriterias)
        if (!empty($aCriterias['magic-search'])) {
            $aWhere[] = '((`name` LIKE :magicsearch))';
            $aParams[':magicsearch'] = '%'. $aCriterias['magic-search'] .'%';
        }

        if (count($aWhere) > 0) {
            // Si au moins un critère de recherche, on applique le WHERE et chaque condition (c1 AND c2 AND c3)
            $sQuery .= ' WHERE ' . implode(' AND ', $aWhere);
        }

        // Execution de la requête (query)
        $oPdoStatement = $oPdo->prepare($sQuery);
        $oPdoStatement->execute($aParams);

        // Parcours des résultats (while + fetch)
        return static::extracted($oPdoStatement);
    }

    /**
     * @param array $aCriterias
     * @return array
     */
    protected static function buildCriterias(array $aCriterias): array
    {
        $aWhere = $aParams = [];

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