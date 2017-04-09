<?php

namespace App\Controller;

class Chapter7Controller extends Chapter
{
    protected function code51()
    {
        $this->getCode(__FILE__, 'code51');
        // $csrfToken = 'generated-random-value';
        // $this->session->set('csrf-token', $csrfToken);
        // $this->view->set('csrf-token', $csrfToken);
        // $this->session->get('csrf-token') == $_POST['csrf-token'] &&
        //<code51>
        setcookie('authorized', 1);
        $this->view->set('action', $this->url('chapter7') . '&code=51');
        if (isset($_POST['username']) && isset($_COOKIE['authorized']) && $_COOKIE['authorized']) {
            $this->view->set('message', "{$_POST['username']} has been deleted successfully");
        }
        //</code51>
        $html = $this->view->render('sample/code51');
        $this->view->set('result', $html);
    }

    protected function code52()
    {
        return $this->code51();
        $this->getCode(__FILE__, 'code52');
        //<code52>
        //</code52>
        $html = $this->view->render('sample/code52');
        $this->view->set('result', $html);
    }

    protected function code53()
    {
        $this->getCode(__FILE__, 'code53');
        //<code53>
        //</code53>
        $html = $this->view->render('sample/code53');
        $this->view->set('result', $html);
    }

    protected function code54()
    {
        $this->getCode(__FILE__, 'code54');
        //<code54>
        //</code54>
        $html = $this->view->render('sample/code54');
        $this->view->set('result', $html);
    }

    protected function code55()
    {
        $this->getCode(__FILE__, 'code55');
        //<code55>
        //</code55>
        $html = $this->view->render('sample/code55');
        $this->view->set('result', $html);
    }
}