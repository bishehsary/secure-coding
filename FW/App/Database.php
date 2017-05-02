<?php

namespace FW\App;


use PDO;
use PDOException;

class Database
{
    /** @var  PDO[] */
    private static $dbs = [];

    static function init($config, $key = 'main')
    {
        if (isset(self::$dbs[$key])) return true;
        try {
            $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
            static::$dbs[$key] = new PDO("{$config['dbms']}:dbname={$config['database']}; host={$config['host']}; port={$config['port']}; charset=utf8mb4",
                $config['username'], $config['password'], $options);
            static::$dbs[$key]->exec("SET NAMES 'UTF8'");
            if ($config['generateSchema']) {
                return self::generateSchema($config['setupFile'], $key);
            }
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    static function generateSchema($file, $key)
    {
        include $file;
        $sql = getSchemaSql();
        try {
            self::$dbs[$key]->exec($sql);
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            return false;
        }
        return true;
    }

    static function getInstance($key = 'main')
    {
        return self::$dbs[$key] ?? null;
    }
}