<?php

namespace App\Controller;

use App\Util\TokenBasedSession;
use FW\App\Config;
use FW\Util\Util;

class Chapter4Controller extends Chapter
{
    /** @var  TokenBasedSession */
    private $tokenSession;

    protected function code37()// Session management techniques
    {
        $this->getCode(__FILE__, 'code37');
        $this->view->set('link', [
            ['Session Management Cheat Sheet', 'https://www.owasp.org/index.php/Session_Management_Cheat_Sheet'],
            ['PHP Session with Redis', 'https://www.digitalocean.com/community/tutorials/how-to-set-up-a-redis-server-as-a-session-handler-for-php-on-ubuntu-14-04'],
        ]);
        $this->view->set('session', Util::genUrl('session'));
        //<code37>
        //</code37>
        $this->view->set('result', $this->view->render('sample/code37'));
    }

    protected function code39()// Avoiding session hijacking
    {
        $this->getCode(__FILE__, 'code39');
        $this->view->set('link', [
            ['Session Hijacking Attack', 'https://www.owasp.org/index.php/Session_hijacking_attack']
        ]);
        $config = Config::getInstance();
        $tokenKeyName = $config->security['sessionKey'];
        $token = $_COOKIE[$tokenKeyName] ?? null;
        //<code39>
        // @bootstrap
        $this->tokenSession = new TokenBasedSession($config->security['sessionHost']);
        if (($errorCode = $this->tokenSession->init($token)) === true) {
            if ($this->request->hasPost('update')) {
                $this->tokenSession->set('user', ['username' => $this->request->post('username')]);
            }
            $this->view->set('user', $this->tokenSession->get('user'));
        } else {
            $this->view->set('error', "Session initiation failed [{$errorCode}]");
        }
        //</code39>
        setcookie($tokenKeyName, $this->tokenSession->getToken());
        $this->view->set('result', $this->view->render('sample/code39'));
    }

    protected function code40()// Cookie based session management
    {
        $this->getCode(__FILE__, 'code40');
        //<code40>
        //</code40>
        $this->view->set('result', $this->view->render('sample/code40'));
    }

    protected function code41()// Cookie information leakage
    {
        $this->getCode(__FILE__, 'code41');
        //<code41>
        //</code41>
        $this->view->set('result', $this->view->render('sample/code41'));
    }

    protected function code42()// Cookie Attribute
    {
        $this->getCode(__FILE__, 'code42');
        $this->view->set('link', [
            ['function.setcookie', 'http://php.net/manual/en/function.setcookie.php'],
            ['Secure Flag', Util::genUrl('chapter1') . '?code=14'],
            ['Http Only Flag', Util::genUrl('chapter1') . '?code=15']
        ]);
        //<code42>
        $this->view->set('cookie', [
            ['string', '$name', true, null],
            ['string', '$value', false, '""'],
            ['int', '$expire', false, '0'],
            ['string', '$path', false, '""'],
            ['string', '$domain', false, '""'],
            ['bool', '$secure', false, 'false'],
            ['bool', '$httponly', false, 'false'],
        ]);
        //</code42>
        $this->view->set('result', $this->view->render('sample/code42'));
    }

    protected function code43()// Session Expiration
    {
        $this->getCode(__FILE__, 'code43');
        //<code43>
        if ($this->request->hasPost('renew')) {
            setcookie('firstCookie', 'firstCookieValue', time() + 6 * 3600);
        } elseif ($this->request->hasPost('expire')) {
            setcookie('firstCookie', 'firstCookieValue', time() - 3600);
        }
        //</code43>
        $this->view->set('result', $this->view->render('sample/code43'));
    }

    protected function code44()// Session management common vulnerabilities
    {
        $this->getCode(__FILE__, 'code44');
        //<code44>
        //</code44>
        $this->view->set('result', $this->view->render('sample/code44'));
    }
}