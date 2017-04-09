<?php


namespace App\Controller;


use FW\App\Controller;

class AccountController extends Controller
{

    function indexAction()
    {
        $this->view->html('<h1>Account Controller</h1>');
    }

    function loginAction()
    {
        if (isset($_POST['login'])) {
            if ($_POST['password'] == 'tntFx256') {
                $this->session->set('user', ['role' => 'admin']);
                $this->response->redirect($this->url($_GET['controller']?? '', $_GET['action']??''));
                return;
            }
        }
        $this->view->html($this->view->render('login'));
    }

    function logoutAction()
    {
        $this->session->remove('user');
        $this->response->redirect($this->url());
    }
}