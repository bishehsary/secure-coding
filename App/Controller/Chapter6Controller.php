<?php

namespace App\Controller;

class Chapter6Controller extends Chapter
{
    protected function code49()// Preventing HTML injection
    {
        $this->getCode(__FILE__, 'code49');
        $this->view->set('link', [
            ['htmlentities', 'http://php.net/manual/en/function.htmlentities.php'],
            ['htmlspecialchars', 'http://php.net/manual/en/function.htmlspecialchars.php']
        ]);
        //<code49>
        $xss = '<script>alert("xss")</script>';
        $this->view->set('escape', [
            'htmlentities' => htmlentities($xss),
            'htmlentities-ENT_QUOTES' => htmlentities($xss, ENT_QUOTES),
            'htmlspecialchars' => htmlspecialchars($xss)
        ]);
        $this->view->set('xss', $xss);
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