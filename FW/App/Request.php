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

    function hasGet($name)
    {
        return isset($_GET[$name]);
    }

    function get($name = null, $defaultValue = null)
    {
        return $this->retrieve($_GET, $name, $defaultValue);
    }

    function hasPost($name)
    {
        return isset($_POST[$name]);
    }

    function post($name = null, $defaultValue = null)
    {
        return $this->retrieve($_POST, $name, $defaultValue);
    }

    function hasJson($name)
    {
        if (!isset($this->jsonStorage)) {
            $this->jsonStorage = json_decode(file_get_contents('php://input'), true);
        }
        return isset($this->jsonStorage[$name]);
    }

    function json($name = null, $defaultValue = null)
    {
        if (!isset($this->jsonStorage)) {
            $this->jsonStorage = json_decode(file_get_contents('php://input'), true);
        }
        return $this->retrieve($this->jsonStorage, $name, $defaultValue);
    }

    function hasServer($name)
    {
        return isset($_SERVER[$name]);
    }

    function server($name = null, $defaultValue = null)
    {
        return $this->retrieve($_SERVER, $name, $defaultValue);
    }

    function hasCookie($name)
    {
        return isset($_COOKIE[$name]);
    }

    function cookie($name = null, $defaultValue = null)
    {
        return $this->retrieve($_COOKIE, $name, $defaultValue);
    }

    function has($name)
    {
        return isset($_REQUEST[$name]);
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