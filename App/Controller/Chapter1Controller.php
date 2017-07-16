<?php

namespace App\Controller;

class Chapter1Controller extends Chapter
{
    protected function code13()// X-XSS-Protection
    {
        $this->view->set('link', [
            ['X-XSS-Protection', 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-XSS-Protection']
        ]);
        $this->getCode(__FILE__, 'code13');
        $this->view->set('xss', $this->request->get('xss', ''));
        //<code13>
        //$this->response->header('X-XSS-Protection', '1; mode=block');
        //</code13>
        $this->view->set('result', $this->view->render('sample/code13'));
    }

    protected function code14()// Secure Flag
    {
        $this->view->set('link', [
            ['function.setcookie', 'http://php.net/manual/en/function.setcookie.php'],
            ['session.cookie-secure', 'http://php.net/manual/en/session.configuration.php#ini.session.cookie-secure'],
        ]);
        $this->getCode(__FILE__, 'code14');
        //<code14>
        // session_set_cookie_params(3 * 3600, '/', null, true, false);
        setcookie('cookieName', 'cookieValue', null, null, null, false, false);
        setcookie('secureCookieName', 'secureCookieValue', null, null, null, true, true);
        //</code14>
        $this->view->set('result', $this->view->render('sample/code14'));
    }

    protected function code15()// Http Only Flag
    {
        $this->view->set('link', [
            ['function.setcookie', 'http://php.net/manual/en/function.setcookie.php'],
            ['session.cookie-httponly', 'http://php.net/manual/en/session.configuration.php#ini.session.cookie-httponly'],
        ]);
        $this->getCode(__FILE__, 'code15');
        // only for this variable
        //<code15>
        // session_set_cookie_params(3 * 3600, '/', null, false, true);
        setcookie('cookieName', 'cookieValue', null, null, null, false, false);
        setcookie('httpOnlyCookieName', 'httpOnlyCookieValue', null, null, null, false, true);
        //</code15>
        $this->view->set('result', $this->view->render('sample/code15'));
    }

    protected function code16()// PHP Header
    {
        $this->view->set('link', [
            ['function.header-remove', 'http://php.net/manual/en/function.header-remove.php'],
            ['ini.expose-php', 'http://php.net/manual/en/ini.core.php#ini.expose-php']
        ]);
        $this->getCode(__FILE__, 'code16');
        //<code16>
        /**
         * @file php.ini
         * @directive expose_php=Off
         */
        // header_remove('X-Powered-By');
        //</code16>
        $this->view->set('result', $this->view->render('sample/code16'));
    }

    protected function code17()// MVC Header
    {
        $this->view->set('link', []);
        $this->getCode(__FILE__, 'code17');
        //<code17>
        //</code17>
        $this->view->set('result', $this->view->render('sample/code17'));
    }

    protected function code18()// Server Header
    {
        $this->getCode(__FILE__, 'code18');
        //<code18>
        /**
         * @file C:\xampp\apache\conf\extra\httpd-default.conf
         * @directive ServerTokens
         * @directive ServerSignature
         * @directive Header unset "X-Powered-By"
         */
        //</code18>
        $this->view->set('result', $this->view->render('sample/code18'));
    }

    protected function code19()// Other Security Flags
    {
        $this->view->set('link', [
            ['Secure Web App', 'https://www.smashingmagazine.com/2017/04/secure-web-app-http-headers'],
            ['X-Content-Type-Options', 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Content-Type-Options'],
            ['X-Frame-Options', 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options'],
            ['Strict-Transport-Security', 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security'],
            ['Content-Security-Policy', 'https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP']
        ]);
        // https://www.developsec.com/2015/09/17/http-strict-transport-security-hsts-overview/
        $this->getCode(__FILE__, 'code19');
        //<code19>
        // $this->response->header('X-Content-Type-Options', 'nosniff');
        // $this->response->header('X-Frame-Options', 'SAMEORIGIN');
        // $this->response->header('Strict-Transport-Security', 'max-age=31536000');
        // $this->response->header('Content-Security-Policy', "default-src 'self' 'unsafe-inline'");
        //</code19>
        $this->view->set('result', $this->view->render('sample/code19'));
    }
}