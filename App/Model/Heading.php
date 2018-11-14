<?php

namespace App\Model;

use FW\App\Model;

class Heading extends Model
{
    public $id;
    public $title;
    public $parent;

    function __construct()
    {
        $this->tableName = 'heading';
    }

    function save()
    {
        if ($this->id) {
            $statement = self::$db->prepare("INSERT INTO `{$this->tableName}`(`id`,`title`,`parent`)VALUES(?,?,?)");
            $statement->execute([$this->id, $this->title, $this->parent]);
        } else {
            $statement = self::$db->prepare("INSERT INTO `{$this->tableName}`(`title`,`parent`)VALUES(?,?)");
            $statement->execute([$this->title, $this->parent]);
            $this->id = self::$db->lastInsertId();
        }
        return $this->id;
    }

    function markAsDone($id)
    {
        $statement = self::$db->prepare("UPDATE `{$this->tableName}` SET `done`=1 WHERE `id`=?");
        return $statement->execute([$id]);
    }

    function getTableSql($dropFirst = false)
    {
        $sql = "
CREATE TABLE IF NOT EXISTS `{$this->tableName}` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `parent` INT(11) DEFAULT NULL,
  `title` VARCHAR (128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
        ";
        return ($dropFirst ? "DROP TABLE IF EXISTS `{$this->tableName}`;" : '') . $sql;
    }
}