<?php

namespace App\Controller;

class Chapter11Controller extends Chapter
{
    protected function code69()
    {
        $this->getCode(__FILE__, 'code69');
        //<code69>
        //</code69>
        $html = $this->view->render('sample/code69');
        $this->view->set('result', $html);
    }

    protected function code70()
    {
        $this->getCode(__FILE__, 'code70');
        //<code70>
        //</code70>
        $html = $this->view->render('sample/code70');
        $this->view->set('result', $html);
    }

    protected function code71()
    {
        $this->getCode(__FILE__, 'code71');
        //<code71>
        //</code71>
        $html = $this->view->render('sample/code71');
        $this->view->set('result', $html);
    }

    protected function code72()
    {
        $this->getCode(__FILE__, 'code72');
        //<code72>
        //</code72>
        $html = $this->view->render('sample/code72');
        $this->view->set('result', $html);
    }
}