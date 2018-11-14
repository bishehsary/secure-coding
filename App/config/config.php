<?php

include __DIR__ . '/acl-setup.php';
$root = dirname(dirname(__DIR__));

FW\App\Config::init([
    'mode' => \FW\App\App::MODE_DEVELOPMENT,
    'root' => $root,
    'server' => [
        'protocol' => 'http',
        'host' => 'sc.io',
        'port' => '80',
        'base' => '/',
    ],
    'database' => [
        'dbms' => 'mysql',
        'host' => '127.0.0.1',
        'database' => 'coding',
        'username' => 'root',
        'password' => '',
        'port' => '3306',
        'generateSchema' => false,
        'dropTables' => false,
        'setupFile' => __DIR__ . '/db-setup.php'
    ],
    'security' => [
        'sessionKey' => 'X-AUTH-TOKEN',
        'sessionHost' => 'localhost',
        'sessionTimeout' => 3600
    ],
    'gitHub' => [
        'client' => 'ec5b78bac564363dd6aa',
        'secret' => '85168874cf3f097568f2080a53877c01cdfab2b0',
        'state' => 'o9y3oVfrfg9jbJ3g998br69zUyHiz1o7',
        'redirect' => 'http://sc.io/gitHub'
    ]
]);
