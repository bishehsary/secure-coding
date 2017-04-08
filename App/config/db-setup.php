<?php
function getSchemaSql()
{
    $drop = \FW\App\Config::getInstance()->database['dropTables'];
    $models = [
        (new \App\Model\Heading())->getTableSql($drop)
    ];
    $sql = '';
    foreach ($models as $model) {
        $sql .= $model;
    }
    return $sql;
}
