<?php

namespace FW\App;


class Session
{
    private static $instance;

    private function __construct()
    {
        session_start();
    }

    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    public function get($name)
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    public function remove($name)
    {
        unset($_SESSION[$name]);
    }

    public function destroy()
    {
        session_destroy();
    }

    static function getInstance(): Session
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}