<?php

namespace FW\App;


class View
{
    private static $response;
    private $frame = 'default';
    private $isHtml = false;
    private $variables = [];

    function __construct($frame = 'default')
    {
        self::$response = Response::getInstance();
        $this->frame = $frame;
    }

    public function get($name)
    {
        return isset($this->variables[$name]) ? $this->variables[$name] : null;
    }

    public function set($name, $value)
    {
        $this->variables[$name] = $value;
    }

    private function flushFrameHeader()
    {
        $path = Config::getInstance()->root . "/App/View/frames/{$this->frame}-header.phtml";
        if (is_file($path)) {
            $this->startBuffering();
            include $path;
            self::$response->html($this->stopBuffering());
        }
    }

    private function flushFrameFooter()
    {
        $path = Config::getInstance()->root . "/App/View/frames/{$this->frame}-footer.phtml";
        if (is_file($path)) {
            $this->startBuffering();
            include $path;
            self::$response->html($this->stopBuffering());
        }
    }

    private function startBuffering()
    {
        ob_start();
    }

    private function stopBuffering()
    {
        return ob_get_clean();
    }

    public function render($tpl)
    {
        $path = Config::getInstance()->root . "/App/View/templates/{$tpl}.phtml";
        if (is_file($path)) {
            $this->startBuffering();
            include $path;
            return $this->stopBuffering();
        }
        return '';
    }

    public function json($data)
    {
        self::$response->json($data);
    }

    public function text($data)
    {
        self::$response->text($data);
    }

    public function html($html)
    {
        if (!$this->isHtml) {
            $this->flushFrameHeader();
            $this->isHtml = true;
        }
        self::$response->html($html);
    }

    function __destruct()
    {
        if ($this->isHtml) {
            $this->flushFrameFooter();
        }
    }
}