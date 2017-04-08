<?php

namespace FW\App;


class View
{
    private $frame = 'default';
    private $contentHasBeenSent = false;
    private $isHtml = false;
    private $variables = [];

    function __construct($frame = 'default')
    {
        $this->frame = $frame;
    }

    function header($name, $value)
    {
        if ($this->contentHasBeenSent) return false;
        header("{$name}: $value");
        return true;
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
            $this->contentHasBeenSent = true;
            include $path;
        }
    }

    private function flushFrameFooter()
    {
        $path = Config::getInstance()->root . "/App/View/frames/{$this->frame}-footer.phtml";
        if (is_file($path)) {
            include $path;
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
        if (!$this->contentHasBeenSent) {
            header('Content-Type: application/json; charset=utf-8');
            $this->contentHasBeenSent = true;
        }
        echo json_encode($data);
    }

    public function text($data)
    {
        if (!$this->contentHasBeenSent) {
            header('Content-Type: text/plain; charset=utf-8');
            $this->contentHasBeenSent = true;
        }
        echo $data;
    }

    public function html($html)
    {
        if (!$this->contentHasBeenSent) {
            header('Content-Type: text/html; charset=utf-8');
            $this->contentHasBeenSent = true;
            $this->flushFrameHeader();
        }
        $this->isHtml = true;
        echo $html;
    }

    function __destruct()
    {
        if ($this->isHtml && $this->contentHasBeenSent) {
            $this->flushFrameFooter();
        }
    }

}