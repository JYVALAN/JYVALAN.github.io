<?php

namespace Otopix\Repository;

use Otopix\Manager\DbManager;

abstract class AbstractRepository
{
    

    /**
     * abstract : permet de ne pas écrire le code de la fonction
     * et de forcer les classes enfants à le faire (de la même manière)
     * @return array
     */
    abstract public static function findAll(): array;

    /**
     * @param int $iId
     * @return object|null
     */
    abstract public static function find(int $iId): ?object;

    abstract public static function findBy(array $aCriterias): array;

    abstract protected static function buildCriterias(array $aCriterias): array;

    abstract protected static function hydrate(array $aDbInfo): object;

    /**
     * @param array $aCriterias
     *
     * @return int
     * @throws \Exception
     */
    public static function countBy(array $aCriterias): int
    {
        $oPdo = DbManager::getInstance();

        $aCriteriasInfo = static::buildCriterias($aCriterias);

        $sQuery = 'SELECT COUNT(*) FROM `'. static::TABLE .'`' . $aCriteriasInfo['where'];

        // Execution de la requête (query)
        $oPdoStatement = $oPdo->prepare($sQuery);
        $oPdoStatement->execute($aCriteriasInfo['params']);

        // Parcours des résultats (while + fetch)
        return $oPdoStatement->fetchColumn(0);
    }

    /**
     * @param \PDOStatement $oPdoStatement
     * @return array
     * @throws \Exception
     */
    protected static function extracted(\PDOStatement $oPdoStatement): array
    {
        $aList = [];

        while ($aDbInfo = $oPdoStatement->fetch(\PDO::FETCH_ASSOC)) {
            $aList[] = static::hydrate($aDbInfo);
        }

        return $aList;
    }
}