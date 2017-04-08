<?php

namespace FW\App;


class App
{
    const STATUS_UNAUTHORIZED = 1;
    const STATUS_OK = 2;
    const MODE_DEVELOPMENT = 1;
    const MODE_PRODUCTION = 2;
    private $config;

    function __construct(Config $config)
    {
        Session::init();
        $this->config = $config;
        if ($this->config->mode == App::MODE_PRODUCTION) {
            error_reporting(0);
        }
        if ($this->config->database) {
            if (true !== ($result = Database::init($this->config->database))) {
                var_dump($result);
            }
            Model::$db = Database::getInstance();
        }
    }

    function run($role)
    {
        $controllerName = isset($_GET['controller']) ? $_GET['controller'] : 'index';
        $actionName = isset($_GET['action']) ? $_GET['action'] : 'index';
        if (Acl::isAllowed($role, $controllerName, $actionName)) {
            $controllerName = strtoupper($controllerName[0]) . substr($controllerName, 1);
            $controllerName = "App\\Controller\\{$controllerName}Controller";
            /** @var Controller $controller */
            $controller = new $controllerName($this->config);
            $controller->process($actionName);
            return self::STATUS_OK;
        }
        return self::STATUS_UNAUTHORIZED;
    }
}