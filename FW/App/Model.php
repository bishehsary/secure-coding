<?php

namespace FW\App;

use PDO;

abstract class Model
{
    /** @var PDO */
    public static $db;
    protected $tableName;

    protected static function getTableName()
    {
        preg_match("/[a-z0-9_]+$/i", get_called_class(), $match);
        $className = $match[0];
        return strtolower($className[0]) . substr($className, 1);
    }

    /**
     * @param array $properties ['fieldName'=> value, 'anotherFieldName'=> anotherValue]
     * @param mixed $fields ['fieldName','secondFieldName]
     * @param mixed $order ['fieldName'=>true, 'anotherFieldName'=> false]
     * @return array<self>
     */
    static function find($properties = [], $fields = null, $order = null)
    {
        $tableName = self::getTableName();
        $condition = '';
        $values = [];
        foreach ($properties as $field => $value) {
            $condition .= " AND `{$field}`=?";
            $values[] = $value;
        }
        $condition = count($values) ? ('WHERE ' . substr($condition, 5)) : '';
        $fields = $fields ? implode(',', $fields) : '*';
        $orderBy = '';
        if ($order && count($order)) {
            foreach ($order as $field => $asc) {
                $orderBy .= ',' . $field . ($asc ? ' ASC' : ' DESC');
            }
            $orderBy = 'ORDER BY ' . substr($orderBy, 1);
        }
        $statement = self::$db->prepare("SELECT {$fields} FROM {$tableName} {$condition} {$orderBy}");
        $statement->execute($values);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $id
     * @return static|null
     */
    static function findById($id)
    {
        $tableName = self::getTableName();
        $statement = self::$db->prepare("SELECT * FROM {$tableName} WHERE id=?");
        $statement->execute([$id]);
        $record = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (count($record) == 1) {
            return self::init($record[0]);
        }
        return null;
    }

    static function init($properties)
    {
        $instance = new static();
        foreach ($properties as $property => $value) {
            $instance->$property = $value;
        }
        return $instance;
    }

    static function delete($id)
    {
        $tableName = self::getTableName();
        $s = self::$db->prepare("DELETE FROM `{$tableName}` WHERE id=?");
        return $s->execute([$id]);
    }

    abstract function save();

    abstract function getTableSql($dropFirst = false);
}