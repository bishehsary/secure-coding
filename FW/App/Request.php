<?php


namespace FW\App;


class Request
{
    private static $instance;

    private function __construct()
    {

    }

    function get($name, $defaultValue)
    {
        return $this->retrieve($_GET, $name, $defaultValue);
    }

    function post($name, $defaultValue)
    {
        return $this->retrieve($_POST, $name, $defaultValue);
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