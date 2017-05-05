<?php

use FW\App\App;
use FW\App\Config;

$loader = require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/App/config/config.php';

$config = Config::getInstance();
$app = new App($config);

$user = \FW\App\Session::getInstance()->get('user');
$role = $user && isset($user['role']) ? $user['role'] : 'guest';

$appStatus = $app->run($role);
if ($appStatus == App::STATUS_UNAUTHORIZED) {
    $c = new \App\Controller\IndexController($config);
    $c->unauthorizedPage("Your access to {$app->controller} is forbidden");
} elseif ($appStatus == App::STATUS_NOT_FOUND) {
    $c = new \App\Controller\IndexController($config);
    $c->notFoundPage("Controller does not exists: {$app->controller}Controller");
}
