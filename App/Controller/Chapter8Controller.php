<?php

namespace App\Controller;

class Chapter8Controller extends Chapter
{
    protected function code56()// Virtual path mapping
    {
        $this->getCode(__FILE__, 'code56');
        //<code56>
        //</code56>
        $this->view->set('result', $this->view->render('sample/code56'));
    }

    protected function code57()// Sanitizing file names
    {
        $this->getCode(__FILE__, 'code57');
        //<code57>
        //</code57>
        $this->view->set('result', $this->view->render('sample/code57'));
    }

    protected function code58()// File extension handling
    {
        $this->getCode(__FILE__, 'code58');
        //<code58>
        //</code58>
        $this->view->set('result', $this->view->render('sample/code58'));
    }

    protected function code59()// Directory listing
    {
        $this->getCode(__FILE__, 'code59');
        //<code59>
        //</code59>
        $this->view->set('result', $this->view->render('sample/code59'));
    }
}