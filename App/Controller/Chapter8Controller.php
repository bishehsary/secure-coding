<?php

namespace App\Controller;

class Chapter8Controller extends Chapter
{
    protected function code56()// Virtual path mapping
    {
        $this->getCode(__FILE__, 'code56');
        //<code56>
        //</code56>
        $html = $this->view->render('sample/code56');
        $this->view->set('result', $html);
    }

    protected function code57()// Sanitizing file names
    {
        $this->getCode(__FILE__, 'code57');
        //<code57>
        //</code57>
        $html = $this->view->render('sample/code57');
        $this->view->set('result', $html);
    }

    protected function code58()// File extension handling
    {
        $this->getCode(__FILE__, 'code58');
        //<code58>
        //</code58>
        $html = $this->view->render('sample/code58');
        $this->view->set('result', $html);
    }

    protected function code59()// Directory listing
    {
        $this->getCode(__FILE__, 'code59');
        //<code59>
        //</code59>
        $html = $this->view->render('sample/code59');
        $this->view->set('result', $html);
    }
}