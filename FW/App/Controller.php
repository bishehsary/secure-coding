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
    /** @var bool */
    protected $scream = true;

    function __construct()
    {
        $this->config = Config::getInstance();
        $this->session = Session::getInstance();
        $this->request = Request::getInstance();
        $this->response = Response::getInstance();
        $this->view = new View();
        $this->updateUserSession();
        $this->registerHandlers();
    }

    protected function init()
    {
    }

    protected function beQuiet($mode = true)
    {
        $this->scream = $mode;
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

    private function registerHandlers()
    {
        set_exception_handler(function ($e) {
            if ($this->scream) {
                $this->errorPage($e);
                exit();
            }
        });
        set_error_handler(function ($code, $message, $file, $line) {
            if ($this->scream) {
                $this->errorPage(join('<br/>', [
                    "Code: {$code}",
                    "Message: {$message}",
                    "File: {$file}",
                    "Line: {$line}"]));
                exit();
            }
        });
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

    protected function url($controller = '', $action = '', $query = '')
    {
        $url = '';
        if ($controller) $url .= "/{$controller}";
        if ($action) $url .= "/{$action}";
        if ($query) $url .= "?{$query}";
        return $url;
    }

    public function notFoundPage($message = null)
    {
        $this->response->header('HTTP/1.1 404 Not Found');
        $this->view->set('message', $message ? $message : '');
        $this->view->html($this->view->render('error/not-found'));
    }

    public function unauthorizedPage($message = null)
    {
        $this->response->header('HTTP/1.1 401 Unauthorized');
        $this->view->set('message', $message ? $message : '');
        $this->view->html($this->view->render('error/unauthorized'));
    }

    public function errorPage($e = null)
    {
        $this->response->header('HTTP/1.1 500 Internal Server Error');
        $this->view->set('message', $e ? $e : 'No details available');
        $this->view->html($this->view->render('error/error'));
    }

    abstract function indexAction();
}