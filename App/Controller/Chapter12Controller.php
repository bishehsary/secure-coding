<?php

namespace App\Controller;

class Chapter12Controller extends Chapter
{
    protected function code73()
    {
        $this->getCode(__FILE__, 'code73');
        //<code73>
        //</code73>
        $html = $this->view->render('sample/code73');
        $this->view->set('result', $html);
    }

    protected function code74()
    {
        $this->getCode(__FILE__, 'code74');
        //<code74>
        //</code74>
        $html = $this->view->render('sample/code74');
        $this->view->set('result', $html);
    }
}