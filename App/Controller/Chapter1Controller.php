<?php

namespace App\Controller;

class Chapter1Controller extends Chapter
{
    protected function code13()
    {
        $this->view->set('link', [
            ['X-XSS-Protection', 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-XSS-Protection']
        ]);
        $this->getCode(__FILE__, 'code13');
        // $this->view->header('X-XSS-Protection', '1; mode=block');
        //<code13>
        //</code13>
        $html = $this->view->render('sample/code13');
        $this->view->set('result', $html);
    }

    protected function code14()
    {
        $this->view->set('link', [
            ['function.setcookie', 'http://php.net/manual/en/function.setcookie.php'],
            ['session.cookie-secure', 'http://php.net/manual/en/session.configuration.php#ini.session.cookie-secure'],
        ]);
        $this->getCode(__FILE__, 'code14');
        // session_set_cookie_params(3 * 3600, '/', null, false, false);
        //<code14>
        setcookie('cookieName', 'cookieValue', null, null, null, false, false);
        setcookie('secureCookieName', 'secureCookieValue', null, null, null, true, false);
        //</code14>
        $html = $this->view->render('sample/code14');
        $this->view->set('result', $html);
    }

    protected function code15()
    {
        $this->view->set('link', [
            ['function.setcookie', 'http://php.net/manual/en/function.setcookie.php'],
            ['session.cookie-httponly', 'http://php.net/manual/en/session.configuration.php#ini.session.cookie-httponly'],
        ]);
        $this->getCode(__FILE__, 'code15');
        // only for this variable
        // session_set_cookie_params(3 * 3600, '/', null, false, true);
        //<code15>
        setcookie('cookieName', 'cookieNewValue', null, null, null, false, true);
        //</code15>
        $html = $this->view->render('sample/code15');
        $this->view->set('result', $html);
    }

    protected function code16()
    {
        $this->getCode(__FILE__, 'code16');
        //<code16>
        //</code16>
        $html = $this->view->render('sample/code16');
        $this->view->set('result', $html);
    }

    protected function code17()
    {
        $this->getCode(__FILE__, 'code17');
        //<code17>
        //</code17>
        $html = $this->view->render('sample/code17');
        $this->view->set('result', $html);
    }

    protected function code18()
    {
        $this->getCode(__FILE__, 'code18');
        //<code18>
        //</code18>
        $html = $this->view->render('sample/code18');
        $this->view->set('result', $html);
    }

    protected function code19()
    {
        $this->view->set('link', [
            ['X-Content-Type-Options', 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Content-Type-Options']
        ]);
        $this->getCode(__FILE__, 'code19');
        //<code19>
        $this->view->header('X-Content-Type-Options', 'nosniff');
        //</code19>
        $html = $this->view->render('sample/code19');
        $this->view->set('result', $html);
    }
}