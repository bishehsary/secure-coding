<?php

namespace App\Controller;

class Chapter4Controller extends Chapter
{
    protected function code37()// Session management techniques
    {
        $this->getCode(__FILE__, 'code37');
        //<code37>
        //</code37>
        $html = $this->view->render('sample/code37');
        $this->view->set('result', $html);
    }

    protected function code38()
    {
        $this->getCode(__FILE__, 'code38');
        //<code38>
        //</code38>
        $html = $this->view->render('sample/code38');
        $this->view->set('result', $html);
    }

    protected function code39()// Avoiding session hijacking
    {
        $this->getCode(__FILE__, 'code39');
        //<code39>
        //</code39>
        $html = $this->view->render('sample/code39');
        $this->view->set('result', $html);
    }

    protected function code40()// Cookie based session management
    {
        $this->getCode(__FILE__, 'code40');
        //<code40>
        //</code40>
        $html = $this->view->render('sample/code40');
        $this->view->set('result', $html);
    }

    protected function code41()// Cookie information leakage
    {
        $this->getCode(__FILE__, 'code41');
        //<code41>
        //</code41>
        $html = $this->view->render('sample/code41');
        $this->view->set('result', $html);
    }

    protected function code42()// Cookie Attribute
    {
        $this->getCode(__FILE__, 'code42');
        //<code42>
        //</code42>
        $html = $this->view->render('sample/code42');
        $this->view->set('result', $html);
    }

    protected function code43()// Session Expiration
    {
        $this->getCode(__FILE__, 'code43');
        //<code43>
        //</code43>
        $html = $this->view->render('sample/code43');
        $this->view->set('result', $html);
    }

    protected function code44()// Session management common vulnerabilities
    {
        $this->getCode(__FILE__, 'code44');
        //<code44>
        //</code44>
        $html = $this->view->render('sample/code44');
        $this->view->set('result', $html);
    }
}