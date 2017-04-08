<?php

namespace FW\App;

abstract class Controller
{
    /** @var  View */
    protected $view;
    /** @var  Config */
    protected $config;

    function __construct($config)
    {
        $this->view = new View();
        $this->view->set('user', Session::get('user'));
        $this->config = $config;
    }

    function process($action = '')
    {
        try {
            if (!$action) {
                $this->indexAction();
            } else {
                $method = "{$action}Action";
                if (method_exists($this, $method)) {
                    $this->$method();
                } else {
                    $this->notFoundPage("Error at Controller::process({$action}) Method [$method] does not exist");
                }
            }
        } catch (\Exception $e) {
            $this->errorPage($e);
        }
    }

    protected function url($controller = '', $action = '')
    {
        $url = '?';
        if ($controller) $url .= "controller={$controller}";
        if ($action) $url .= ($controller ? '&' : '') . "action={$action}";
        return $url;
    }

    protected function redirect($url)
    {
        if (!$this->view->header('Location', $url)) {
            $this->view->html("<script>window.location.href='{$url}'</script>");
        }
    }

    protected function notFoundPage($message = null)
    {
        $this->view->set('message', $message ? $message : '');
        $this->view->html($this->view->render('not-found'));
    }

    protected function errorPage($e = null)
    {
        $this->view->set('error', $e ? $e : 'No details available');
        $this->view->html($this->view->render('error'));
    }

    abstract function indexAction();
}