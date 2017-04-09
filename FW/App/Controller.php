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

    function __construct($config)
    {
        $this->session = Session::getInstance();
        $this->request = Request::getInstance();
        $this->response = Response::getInstance();
        $this->view = new View();
        $this->view->set('user', $this->session->get('user'));
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

    public function notFoundPage($message = null)
    {
        $this->view->set('message', $message ? $message : '');
        $this->view->html($this->view->render('not-found'));
    }

    public function errorPage($e = null)
    {
        $this->view->set('error', $e ? $e : 'No details available');
        $this->view->html($this->view->render('error'));
    }

    abstract function indexAction();
}