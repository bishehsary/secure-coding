<?php

namespace App\Controller;

class Chapter9Controller extends Chapter
{
    protected function code60()// Symmetric Encryption
    {
        $this->getCode(__FILE__, 'code60');
        //<code60>
        //</code60>
        $html = $this->view->render('sample/code60');
        $this->view->set('result', $html);
    }

    protected function code61()// Asymmetric Encryption
    {
        $this->getCode(__FILE__, 'code61');
        //<code61>
        //</code61>
        $html = $this->view->render('sample/code61');
        $this->view->set('result', $html);
    }

    protected function code62()// Hashing
    {
        $this->getCode(__FILE__, 'code62');
        //<code62>
        //</code62>
        $html = $this->view->render('sample/code62');
        $this->view->set('result', $html);
    }
}