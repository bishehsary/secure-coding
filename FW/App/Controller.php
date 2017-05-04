<?php

namespace FW\App;

abstract class Controller
{
    /** @var  View */
    protected $view;
    /** @var  Config */
    protected $config;
    /** @var  Session */
    protected $session;
    /** @var  Request */
    protected $request;
    /** @var  Response */
    protected $response;
    /** @var  string */
    protected $action;

    function __construct($config)
    {
        $this->session = Session::getInstance();
        $this->request = Request::getInstance();
        $this->response = Response::getInstance();
        $this->view = new View();
        $this->config = $config;
        $this->updateUserSession();
    }

    protected function init()
    {
    }

    private function updateUserSession()
    {
        $user = $this->session->get('user');
        if ($user && isset($user['visit'])) {
            $now = time();
            if ($now - $user['visit'] > $this->config->security['sessionTimeout']) {
                $this->session->destroy();
            } else {
                $user['visit'] = $now;
                $this->session->set('user', $user);
                $this->view->set('user', $user);
            }
        }
    }

    function process($action = '')
    {
        $this->action = $action ?: 'index';
        $this->init();
        try {
            $this->action = $action;
            $method = "{$action}Action";
            if (method_exists($this, $method)) {
                $this->$method();
            } else {
                $this->notFoundPage("Error at Controller::process({$action}) Method [$method] does not exist");
            }
        } catch (\Exception $e) {
            $this->errorPage($e);
        }
    }

    protected function url($controller = '', $action = '')
    {
        if ($this->config->seo) {
            $url = '';
            if ($controller) $url .= "/{$controller}";
            if ($action) $url .= "/{$action}";
        } else {
            $url = '?';
            if ($controller) $url .= "controller={$controller}";
            if ($action) $url .= ($controller ? '&' : '') . "action={$action}";
        }
        return $url;
    }

    public function notFoundPage($message = null)
    {
        $this->response->header('HTTP/1.1 404 Not Found');
        $this->view->set('message', $message ? $message : '');
        $this->view->html($this->view->render('not-found'));
    }

    public function errorPage($e = null)
    {
        $this->response->header('HTTP/1.1 500 Internal Server Error');
        $this->view->set('error', $e ? $e : 'No details available');
        $this->view->html($this->view->render('error'));
    }

    abstract function indexAction();
}