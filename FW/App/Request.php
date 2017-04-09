<?php


namespace FW\App;


class Request
{
    private static $instance;
    private $jsonStorage;

    private function __construct()
    {

    }

    function get($name, $defaultValue = null)
    {
        return $this->retrieve($_GET, $name, $defaultValue);
    }

    function post($name, $defaultValue = null)
    {
        return $this->retrieve($_POST, $name, $defaultValue);
    }

    function json($name, $defaultValue = null)
    {
        if (!isset($this->jsonStorage)) {
            $this->jsonStorage = json_decode('php://input');
        }
        return $this->retrieve($this->jsonStorage, $name, $defaultValue);
    }

    function server($name, $defaultValue = null)
    {
        return $this->retrieve($_SERVER, $name, $defaultValue);
    }

    function cookie($name, $defaultValue = null)
    {
        return $this->retrieve($_COOKIE, $name, $defaultValue);
    }

    private function retrieve($storage, $name, $defaultValue)
    {
        if (isset($storage[$name])) return $storage[$name];
        return isset($defaultValue) ? $defaultValue : null;
    }

    static function getInstance(): Request
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}