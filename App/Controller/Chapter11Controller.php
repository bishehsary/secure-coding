<?php

namespace App\Controller;

class Chapter11Controller extends Chapter
{
    protected function code69()// Structured exception handling – Try, Catch, Finally
    {
        $this->getCode(__FILE__, 'code69');
        //<code69>
        //</code69>
        $this->view->set('result', $this->view->render('sample/code69'));
    }

    protected function code70()// Creating custom error pages
    {
        $this->getCode(__FILE__, 'code70');
        //<code70>
        //</code70>
        $this->view->set('result', $this->view->render('sample/code70'));
    }

    protected function code71()// HTTP error codes
    {
        $this->getCode(__FILE__, 'code71');
        //<code71>
        //</code71>
        $this->view->set('result', $this->view->render('sample/code71'));
    }

    protected function code72()// Error handling strategies
    {
        $this->getCode(__FILE__, 'code72');
        //<code72>
        //</code72>
        $this->view->set('result', $this->view->render('sample/code72'));
    }
}