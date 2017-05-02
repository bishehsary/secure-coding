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

    public $controller;

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
        $controllerName = $_GET['controller'] ?? '';
        $actionName = $_GET['action'] ?? '';
        if ($this->config->seo) {
            preg_match("/\/?(?P<controller>[a-z0-9]*)(\/?(?P<action>[a-z0-9]*))/", $_SERVER['REQUEST_URI'], $match);
            $controllerName = isset($match['controller']) && $match['controller'] ? $match['controller'] : $controllerName;
            $actionName = isset($match['action']) && $match['action'] ? $match['action'] : $actionName;
        }
        if (!$controllerName) $controllerName = 'index';
        if (!$actionName) $actionName = 'index';
        if (Acl::isAllowed($role, $controllerName, $actionName)) {
            $this->controller = strtoupper($controllerName[0]) . substr($controllerName, 1);
            $controllerPath = __DIR__ . "/../../App/Controller/{$this->controller}Controller.php";
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