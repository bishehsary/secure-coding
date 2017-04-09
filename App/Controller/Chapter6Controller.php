<?php

namespace App\Controller;

class Chapter6Controller extends Chapter
{
    protected function code49()// Preventing HTML injection
    {
        $this->getCode(__FILE__, 'code49');
        //<code49>
        //</code49>
        $this->view->set('result', $this->view->render('sample/code49'));
    }

    protected function code50()// Preventing Cross Site Scripting (XSS)
    {
        $this->getCode(__FILE__, 'code50');
        //<code50>
        //</code50>
        $this->view->set('result', $this->view->render('sample/code50'));
    }
}