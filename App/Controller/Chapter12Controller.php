<?php

namespace App\Controller;

class Chapter12Controller extends Chapter
{
    protected function code73()// Event message structure
    {
        $this->getCode(__FILE__, 'code73');
        //<code73>
        //</code73>
        $this->view->set('result', $this->view->render('sample/code73'));
    }

    protected function code74()// Logging best practices
    {
        $this->getCode(__FILE__, 'code74');
        //<code74>
        //</code74>
        $this->view->set('result', $this->view->render('sample/code74'));
    }
}