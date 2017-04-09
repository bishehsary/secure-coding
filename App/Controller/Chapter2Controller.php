<?php

namespace App\Controller;

class Chapter2Controller extends Chapter
{
    protected function code20()// Authentication Scenarios
    {
        $this->getCode(__FILE__, 'code20');
        //<code20>
        //</code20>
        $html = $this->view->render('sample/code20');
        $this->view->set('result', $html);
    }

    protected function code21()// Implementing form authentication
    {
        $this->getCode(__FILE__, 'code21');
        //<code21>
        //</code21>
        $html = $this->view->render('sample/code21');
        $this->view->set('result', $html);
    }

    protected function code22()// Password Control
    {
        $this->getCode(__FILE__, 'code22');
        //<code22>
        //</code22>
        $html = $this->view->render('sample/code22');
        $this->view->set('result', $html);
    }

    protected function code23()// CAPTCHA Mechanism
    {
        $this->getCode(__FILE__, 'code23');
        //<code23>
        //</code23>
        $html = $this->view->render('sample/code23');
        $this->view->set('result', $html);
    }

    protected function code24()// Mitigating brute force attacks
    {
        $this->getCode(__FILE__, 'code24');
        //<code24>
        //</code24>
        $html = $this->view->render('sample/code24');
        $this->view->set('result', $html);
    }

    protected function code25()// Authentication Protocols (OAuth, OpenId, SAML, FIDO)
    {
        $this->getCode(__FILE__, 'code25');
        //<code25>
        //</code25>
        $html = $this->view->render('sample/code25');
        $this->view->set('result', $html);
    }
}