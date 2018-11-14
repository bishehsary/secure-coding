<?php


namespace App\Controller;

use FW\App\Controller;
use FW\Util\Util;

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
                $this->response->redirect(Util::genUrl($this->request->get('controller'), $this->request->get('action')));
                return;
            }
        }
        $this->view->html($this->view->render('login'));
    }

    function logoutAction()
    {
        $this->session->remove('user');
        $this->response->redirect(Util::genUrl());
    }

    function reloginAction()
    {
        $redirectUrl = $this->request->get('url');
        $urlParts = parse_url($redirectUrl);
        $connector = isset($urlParts['query']) ? '&' : '?';
        if ($this->request->hasPost('login')) {
            $this->response->redirect("{$redirectUrl}{$connector}redirect=true");
//            if ($urlParts['host'] == 'sc.io') {
//            } else {
//                $this->notFoundPage('Invalid redirect url');
//            }
        } else {
            $this->view->html($this->view->render('account/relogin'));
        }
    }
}