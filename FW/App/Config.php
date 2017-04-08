<?php

namespace FW\App;

class Config
{
    private static $instance;

    static function init(array $config)
    {
        self::$instance = new self($config);
    }

    private function __construct(array $config)
    {
        $this->config = $config;
    }

    function __get($name)
    {
        return isset($this->config[$name]) ? $this->config[$name] : null;
    }

    function server()
    {
        $parts = $this->config['server'];
        return "{$parts['protocol']}://{$parts['host']}:{$parts['port']}{$parts['base']}";
    }

    static function getInstance()
    {
        return self::$instance;
    }
}