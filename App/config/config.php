<?php

include __DIR__ . '/acl-setup.php';
$root = dirname(dirname(__DIR__));

FW\App\Config::init([
    'mode' => \FW\App\App::MODE_DEVELOPMENT,
    'root' => $root,
    'server' => [
        'protocol' => 'http',
        'host' => 'localhost',
        'port' => '80',
        'base' => '/',
    ],
    'database' => [
        'dbms' => 'mysql',
        'host' => 'localhost',
        'database' => 'coding',
        'username' => 'root',
        'password' => '',
        'port' => '3306',
        'generateSchema' => false,
        'dropTables' => false,
        'setupFile' => __DIR__ . '/db-setup.php'
    ],
    'security' => [
        'sessionTimeout' => 3600
    ],
    'gitHub' => [
        'client' => 'ec5b78bac564363dd6aa',
        'secret' => '318ea2381a55b3a4c77a16f13104767e934b736e',
        'state' => 'o9y3oVfrfg9jbJ3g998br69zUyHiz1o7',
        'redirect' => 'http://sc.io/?controller=gitHub'
    ]
]);
