<?php

namespace App\Controller;

class Chapter3Controller extends Chapter
{
    protected function code26()// Authorization models
    {
        $this->getCode(__FILE__, 'code26');
        //<code26>
        //</code26>
        $html = $this->view->render('sample/code26');
        $this->view->set('result', $html);
    }

    protected function code27()// URL authorization
    {
        $this->getCode(__FILE__, 'code27');
        //<code27>
        //</code27>
        $html = $this->view->render('sample/code27');
        $this->view->set('result', $html);
    }

    protected function code28()// File authorization
    {
        $this->getCode(__FILE__, 'code28');
        //<code28>
        //</code28>
        $html = $this->view->render('sample/code28');
        $this->view->set('result', $html);
    }

    protected function code29()// Role Based Access Control (RBAC)
    {
        $this->getCode(__FILE__, 'code29');
        //<code29>
        //</code29>
        $html = $this->view->render('sample/code29');
        $this->view->set('result', $html);
    }

    protected function code30()// Discretionary Access Control (DAC)
    {
        $this->getCode(__FILE__, 'code30');
        //<code30>
        //</code30>
        $html = $this->view->render('sample/code30');
        $this->view->set('result', $html);
    }

    protected function code31()// Mandatory Access Control (MAC)
    {
        $this->getCode(__FILE__, 'code31');
        //<code31>
        //</code31>
        $html = $this->view->render('sample/code31');
        $this->view->set('result', $html);
    }

    protected function code32()// Permission Based Access Control
    {
        $this->getCode(__FILE__, 'code32');
        //<code32>
        //</code32>
        $html = $this->view->render('sample/code32');
        $this->view->set('result', $html);
    }

    protected function code33()// Working with identities
    {
        $this->getCode(__FILE__, 'code33');
        //<code33>
        //</code33>
        $html = $this->view->render('sample/code33');
        $this->view->set('result', $html);
    }

    protected function code34()// Claim based authorization
    {
        $this->getCode(__FILE__, 'code34');
        //<code34>
        //</code34>
        $html = $this->view->render('sample/code34');
        $this->view->set('result', $html);
    }

    protected function code35()// Role manager
    {
        $this->getCode(__FILE__, 'code35');
        //<code35>
        //</code35>
        $html = $this->view->render('sample/code35');
        $this->view->set('result', $html);
    }

    protected function code36()// MVC Authorization
    {
        $this->getCode(__FILE__, 'code36');
        //<code36>
        //</code36>
        $html = $this->view->render('sample/code36');
        $this->view->set('result', $html);
    }
}