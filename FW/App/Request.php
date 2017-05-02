<?php


namespace FW\App;


class Request
{
    const GET = 1;
    const POST = 2;
    const SERVER = 3;
    const COOKIE = 4;

    private static $instance;
    private $jsonStorage;

    private function __construct()
    {

    }

    function has($name, $storage)
    {
        switch ($storage) {
            case self::GET:
                return isset($_GET[$name]);
            case self::POST:
                return isset($_POST[$name]);
            case self::SERVER:
                return isset($_SERVER[$name]);
            case self::COOKIE:
                return isset($_COOKIE[$name]);
        }
        return false;
    }

    function get($name = null, $defaultValue = null)
    {
        return $this->retrieve($_GET, $name, $defaultValue);
    }

    function post($name = null, $defaultValue = null)
    {
        return $this->retrieve($_POST, $name, $defaultValue);
    }

    function json($name = null, $defaultValue = null)
    {
        if (!isset($this->jsonStorage)) {
            $this->jsonStorage = json_decode(file_get_contents('php://input'), true);
        }
        return $this->retrieve($this->jsonStorage, $name, $defaultValue);
    }

    function server($name = null, $defaultValue = null)
    {
        return $this->retrieve($_SERVER, $name, $defaultValue);
    }

    function cookie($name = null, $defaultValue = null)
    {
        return $this->retrieve($_COOKIE, $name, $defaultValue);
    }

    private function retrieve($storage, $name, $defaultValue)
    {
        if (!isset($name)) return $storage;
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