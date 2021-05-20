<?php

namespace Core\Model;

use Exception;
use PDO;

class DBFactory
{
    private static $db = null;

    public static $MARIA = "MARIA";
    public static $MYSQL = "MYSQL";

    public static function get(string $dbName): PDO
    {
        if (!self::isDB($dbName)) throw new \Exception("");
        switch ($dbName) {
            case self::$MARIA: return self::maria();
            case self::$MYSQL: return self::mysql();
            default: throw new \Exception("");
        };
    }

    private static function isDB(string $db) {
        return in_array($db, [self::$MARIA, self::$MYSQL]);
    }

    private static function maria(): PDO {
        if (self::$db === null) {
            try {
                $logs = self::getConfig();
                self::$db = new \PDO('maria:host='.$logs['host'].';dbname='.$logs['db_name'].'', ''.$logs['user_name'].'', ''.$logs['password'].'');
            } catch (Exception $ex) {
                die($ex->getMessage());
            }
            self::$db->exec('SET CHARACTER SET utf8")');
        }

        return self::$db;
    }

    private static function mysql(): PDO {
        if (self::$db === null) {
            try {
                $logs = self::getConfig();
                self::$db = new \PDO('mysql:host='.$logs['host'].';dbname='.$logs['db_name'].'', ''.$logs['user_name'].'', ''.$logs['password'].'');
            } catch (Exception $ex) {
                die($ex->getMessage());
            }
            self::$db->exec('SET CHARACTER SET utf8")');
        }

        return self::$db;
    }

    private static function getConfig() {
        return require 'Config/database_config.php';
    }
}