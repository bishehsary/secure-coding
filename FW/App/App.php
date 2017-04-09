<?php

namespace FW\App;


class App
{
    const STATUS_UNAUTHORIZED = 1;
    const STATUS_NOT_FOUND = 2;
    const STATUS_OK = 3;
    const MODE_DEVELOPMENT = 1;
    const MODE_PRODUCTION = 2;
    private $config;
    private $session;

    function __construct(Config $config)
    {
        Session::getInstance();
        $this->config = $config;
        if ($this->config->mode == App::MODE_PRODUCTION) {
            ini_set('display_errors', 'Off');
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
            $controllerPath = __DIR__ . "/../../App/Controller/{$controllerName}Controller.php";
            if (!file_exists($controllerPath)) {
                return self::STATUS_NOT_FOUND;
            }
            $controllerName = "App\\Controller\\{$controllerName}Controller";
            /** @var Controller $controller */
            $controller = new $controllerName($this->config, $this->session);
            $controller->process($actionName);
            return self::STATUS_OK;
        }
        return self::STATUS_UNAUTHORIZED;
    }
}