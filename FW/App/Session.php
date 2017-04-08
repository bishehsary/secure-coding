<?php

namespace FW\App;


class Session
{
    static function init()
    {
        session_start();
    }

    static function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    static function get($name)
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    static function remove($name)
    {
        unset($_SESSION[$name]);
    }

    static function destroy()
    {
        session_destroy();
    }
}