<?php

namespace App\Controller;

class Chapter9Controller extends Chapter
{
    protected function code60()// Symmetric Encryption
    {
        $this->getCode(__FILE__, 'code60');
        //<code60>
        //</code60>
        $this->view->set('result', $this->view->render('sample/code60'));
    }

    protected function code61()// Asymmetric Encryption
    {
        $this->getCode(__FILE__, 'code61');
        //<code61>
        //</code61>
        $this->view->set('result', $this->view->render('sample/code61'));
    }

    protected function code62()// Hashing
    {
        $this->getCode(__FILE__, 'code62');
        //<code62>
        //</code62>
        $this->view->set('result', $this->view->render('sample/code62'));
    }
}