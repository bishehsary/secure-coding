<?php

namespace App\Controller;

use App\Util\TokenBasedSession;
use FW\App\Config;
use FW\App\Controller;
use FW\App\Request;

class SessionController extends Controller
{
    /** @var  TokenBasedSession */
    private $tokenSession;
    private $isCookieBased = true;
    private $isAjax = false;
    const TokenKeyName = 'X-AUTH-TOKEN';
    const ServerTokenName = 'HTTP_X_AUTH_TOKEN';

    protected function init()
    {
        if ($this->action == 'index') return;
        $this->isCookieBased = $this->action == 'cookie';
        // check if the system is cookie based
        // if not, it only should check session if it is an ajax call
        $this->isAjax = $this->request->get('ajax', 0);
        if ($this->isCookieBased || (!$this->isCookieBased && $this->isAjax)) {
            $this->tokenSession = new TokenBasedSession(Config::getInstance()->security['sessionHost']);
            $storage = $this->isCookieBased ? $_COOKIE : $_SERVER;
            $token = $storage[$this->isCookieBased ? self::TokenKeyName : self::ServerTokenName] ?? null;
            // checking session validation
            if ($token) {
                $tokenIsValid = $this->tokenSession->init($token);
                if (!$tokenIsValid) {
                    $this->regenerateSession();
                }
            } else {
                $this->tokenSession->init();
                $this->publishToken();
            }
        }
    }

    private function regenerateSession()
    {
        if ($this->tokenSession->destroy()) {
            // todo failed to delete key from redis
        }
        $this->tokenSession->init();
        $this->publishToken();
    }

    private function publishToken()
    {
        $this->isCookieBased ? setcookie(self::TokenKeyName, $this->tokenSession->getToken()) :
            $this->response->header(self::TokenKeyName, $this->tokenSession->getToken());
    }

    function indexAction()
    {
        $this->view->set('cookie', $this->url('session/cookie'));
        $this->view->set('ajax', $this->url('session/ajax'));
        $this->view->html($this->view->render('session/index'));
    }

    function cookieAction()
    {
        // checking for delete
        if ($this->request->has('delete', Request::POST)) {
            $this->regenerateSession();
        }
        if ($this->request->has('update', Request::POST)) {
            $username = $this->request->post('username', '');
            $this->tokenSession->set('user', ['username' => $username]);
        }
        $this->view->set('page', $this->url('session/cookie'));
        $this->view->set('ajax', $this->url('session/ajax'));
        $this->view->set('user', $this->tokenSession->get('user'));
        $this->view->html($this->view->render('session/cookie'));
    }

    function ajaxAction()
    {
        if ($this->isAjax) {
            if ($this->request->get('delete', 0)) {
                $this->regenerateSession();
            } else {
                $username = $this->request->json('username', '');
                if ($username) {
                    $this->tokenSession->set('user', ['username' => $username]);
                }
            }
            $this->view->json(['user' => $this->tokenSession->get('user')]);
        } else {
            $this->view->set('page', $this->url('session/ajax'));
            $this->view->set('cookie', $this->url('session/cookie'));
            $this->view->html($this->view->render('session/ajax'));
        }
    }
}
