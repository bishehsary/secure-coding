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
        $login = $this->request->post('login');
        if ($login) {
            if ($this->request->post('password') == 'adm!nPass') {
                $this->session->set('user', ['role' => 'admin']);
                $this->response->redirect($this->url($this->request->get('controller'), $this->request->get('action')));
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