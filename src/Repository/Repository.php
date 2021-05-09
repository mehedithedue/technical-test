<?php


namespace Repository;

use Exception;
use PDO;
use PDOException;

class Repository
{

    private static $pdo;

    public static function createPDOInstance()
    {
        if (!isset(self:: $pdo)) {
            return self::connection();
        }

        return self::$pdo;

    }


    public static function connection()
    {
        if (!isset(self:: $pdo)) {
            try {
                self:: $pdo = new PDO ('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);

            } catch (PDOException $e) {
                echo "Database connection fail!" . $e->getMessage();
            }
        }
        return self::$pdo;
    }

    public static function prepare($sql)
    {
        return self::connection()->prepare($sql);
    }
}