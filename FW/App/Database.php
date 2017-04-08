<?php

namespace FW\App;


use PDO;
use PDOException;

class Database
{
    /** @var  PDO */
    private static $db = null;

    static function init($config)
    {
        if (self::$db) return true;
        try {
            $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
            static::$db = new PDO("{$config['dbms']}:dbname={$config['database']}; host={$config['host']}; port={$config['port']}; charset=utf8mb4",
                $config['username'], $config['password'], $options);
            static::$db->exec("SET NAMES 'UTF8'");
            if ($config['generateSchema']) {
                return self::generateSchema($config['setupFile']);
            }
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    static function generateSchema($file)
    {
        include $file;
        $sql = getSchemaSql();
        try {
            self::$db->exec($sql);
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            return false;
        }
        return true;
    }

    static function getInstance()
    {
        return self::$db;
    }
}