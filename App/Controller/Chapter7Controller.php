<?php

namespace App\Controller;

class Chapter7Controller extends Chapter
{
    protected function code51()// Cross Site Request Forgery (CSRF)
    {
        $this->getCode(__FILE__, 'code51');
        // $csrfToken = 'generated-random-value';
        // $this->session->set('csrf-token', $csrfToken);
        // $this->view->set('csrf-token', $csrfToken);
        // $this->session->get('csrf-token') == $this->request->post('csrf-token')
        //<code51>
        setcookie('authorized', 1);
        $this->view->set('action', $this->url('chapter7') . '&code=51');
        $username = $this->request->post('username');
        $authorized = $this->request->cookie('authorized');
        if ($username && $authorized) {
            $this->view->set('message', "{$username} has been deleted successfully");
        }
        //</code51>
        $this->view->set('result', $this->view->render('sample/code51'));
    }

    protected function code52()// Anti CSRF token
    {
        return $this->code51();
        $this->getCode(__FILE__, 'code52');
        //<code52>
        //</code52>
        $this->view->set('result', $this->view->render('sample/code52'));
    }

    protected function code53()// CSRF Protection for XHR
    {
        $this->getCode(__FILE__, 'code53');
        //<code53>
        //</code53>
        $this->view->set('result', $this->view->render('sample/code53'));
    }

    protected function code54()// Preventing Open Redirection
    {
        $this->getCode(__FILE__, 'code54');
        //<code54>
        //</code54>
        $this->view->set('result', $this->view->render('sample/code54'));
    }

    protected function code55()// Preventing ClickJacking
    {
        $this->getCode(__FILE__, 'code55');
        //<code55>
        //</code55>
        $this->view->set('result', $this->view->render('sample/code55'));
    }
}