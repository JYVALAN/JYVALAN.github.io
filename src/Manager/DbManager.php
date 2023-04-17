<?php
namespace Otopix\Manager;

class DbManager
{
    /** @var \PDO|null */
    private static ?\PDO $instance = NULL;

    /**
     * @return \PDO
     */
    public static function getInstance(): \PDO
    {
        if (!static::$instance instanceof \PDO) {
            // DSN (Data Source Name) : ligne contenant des informations combinées
            $sDSN = 'mysql:dbname='. DB_NAME .';host='. DB_HOST .';charset=UTF8';
            $aOptions = [
                // Pour Mysql, forcer le passage en UTF8
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
            ];
            $oPdo = new \PDO($sDSN, DB_USER, DB_PWD, $aOptions);
            // On personnalise l'affichage des erreurs (en développement uniquement)
            if (ENV === 'development') {
                $oPdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
            }
            // TODO : Vérifier que la connexion est OK (exceptions)

            static::$instance = $oPdo;
        }

        return static::$instance;
    }
}
