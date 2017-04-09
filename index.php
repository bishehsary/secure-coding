<?php

use FW\App\App;
use FW\App\Config;

$loader = require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/App/config/config.php';

$app = new App(Config::getInstance());

$user = \FW\App\Session::getInstance()->get('user');
$role = $user ? $user['role'] : 'agent';

$appStatus = $app->run($role);
if ($appStatus == App::STATUS_UNAUTHORIZED) {
    $c = new \App\Controller\IndexController(Config::getInstance());
    $c->indexAction();
} elseif ($appStatus == App::STATUS_NOT_FOUND) {
    $c = new \App\Controller\IndexController(Config::getInstance());
    $c->notFoundPage("Controller does not exists: {$_GET['controller']}Controller");
}
