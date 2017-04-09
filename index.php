<?php

use FW\App\App;
use FW\App\Config;

$loader = require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/App/config/config.php';

$app = new App(Config::getInstance());

$user = \FW\App\Session::getInstance()->get('user');
$role = $user ? $user['role'] : 'agent';

if ($app->run($role) == App::STATUS_UNAUTHORIZED) {
    $c = new \App\Controller\IndexController(Config::getInstance());
    $c->loginAction();
}
