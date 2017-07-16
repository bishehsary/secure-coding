<?php

namespace App\Controller;

class Chapter10Controller extends Chapter
{
    protected function code63()// Web services overview
    {
        $this->getCode(__FILE__, 'code63');
        //<code63>
        //</code63>
        $this->view->set('result', $this->view->render('sample/code63'));
    }

    protected function code64()// Security in parsing of XML
    {
        $this->getCode(__FILE__, 'code64');
        $this->view->set('link', [
            ['XML Security', 'https://www.owasp.org/index.php/XML_Security_Cheat_Sheet']
        ]);
        $this->view->set('form', $this->url('chapter10', null, 'code=64'));
        //<code64>
        $url = $this->request->post('url');
        if ($url) {
            $xmlString = file_get_contents($url);
            $xml = simplexml_load_string($xmlString);
            $this->view->set('xml', [
                'title' => $xml->channel->title,
                'desc' => htmlentities($xml->channel->description),
            ]);
        }
        //</code64>
        $this->view->set('result', $this->view->render('sample/code64'));
    }

    protected function code65()// XML security
    {
        $this->getCode(__FILE__, 'code65');
        //<code65>
        //</code65>
        $this->view->set('result', $this->view->render('sample/code65'));
    }

    protected function code66()// AJAX technologies overview
    {
        $this->getCode(__FILE__, 'code66');
        //<code66>
        //</code66>
        $this->view->set('result', $this->view->render('sample/code66'));
    }

    protected function code67()// AJAX attack trends and common attacks
    {
        $this->getCode(__FILE__, 'code67');
        //<code67>
        //</code67>
        $this->view->set('result', $this->view->render('sample/code67'));
    }

    protected function code68()// AJAX defense
    {
        $this->getCode(__FILE__, 'code68');
        //<code68>
        //</code68>
        $this->view->set('result', $this->view->render('sample/code68'));
    }
}