<?php

namespace App\Controller;

use FW\App\Database;
use FW\App\Request;
use GuzzleHttp\Client;

class Chapter2Controller extends Chapter
{
    protected function code20()// Authentication Scenarios
    {
        $this->getCode(__FILE__, 'code20');
        $this->view->set('basicAuthUrl', $this->url('chapter2') . '?code=20&auth=basic');
        $this->view->set('digestAuthUrl', $this->url('chapter2') . '?code=20&auth=digest');
        //<code20>
        if (($authType = $this->request->get('auth'))) {
            $realm = "Secure Area";
            switch ($authType) {
                case 'basic':
                    $user = $this->request->server('PHP_AUTH_USER');
                    $pass = $this->request->server('PHP_AUTH_PW');
                    if ($user && $pass) {
                        $this->view->set('basicAuth', "$user:$pass");
                    } else {
                        $this->response->header('WWW-Authenticate', "Basic realm='{$realm}'");
                        $this->response->header('HTTP/1.0 401 Unauthorized');
                        $this->view->text('Unauthorized');
                        exit;
                    }
                    break;
                case 'digest':
                    $credential = ['username' => 'admin', 'password' => 'admin'];
                    if (($digestString = $this->request->server('PHP_AUTH_DIGEST')) &&
                        $this->digestAuth($digestString, $credential, $realm)
                    ) {
                        $this->view->set('digestAuth', "{$credential['username']}:{$credential['password']}");
                    } else {
                        $this->response->header('HTTP/1.1 401 Unauthorized');
                        $nonce = uniqid();
                        $opaque = md5($realm);
                        $this->response->header('WWW-Authenticate', "Digest realm='{$realm}',qop='auth',nonce='{$nonce}',opaque='{$opaque}'");
                        $this->view->text('Unauthorized');
                        exit;
                    }
                    break;
            }
        }
        //</code20>
        $this->view->set('result', $this->view->render('sample/code20'));
    }

    protected function code21()// Implementing form authentication
    {
        $this->getCode(__FILE__, 'code21');
        $this->view->set('form', $this->url('chapter2') . '?code=21');
        //<code21>
        if ($this->request->post('login')) {
            $username = $this->request->post('username');
            $password = $this->request->post('password');
            // validating username and password (later)
            if ($username == 'username' && $password == 'password') {
                // preventing session fixation
                $this->session->regenerate();
                $user = ['username' => $username, 'role' => 'admin', 'visit' => time()];
                $this->session->set('user', $user);
                $this->view->set('user', $user);
                // redirect if required by business
                // $this->response->redirect($this->url());
                // return;
            } else {
                // enumeration attack possibility
                $this->view->set('error', 'Wrong username/password combination');
            }
        } elseif ($this->request->post('logout')) {
            $this->session->destroy();
            // watch out!
            $this->view->set('user', null);
        }
        //</code21>
        $this->view->set('result', $this->view->render('sample/code21'));
    }

    protected function code22()// Password Control
    {
        $this->getCode(__FILE__, 'code22');
        //<code22>
        // Password policy SHOULD also be checked here
        //</code22>
        $this->view->set('result', $this->view->render('sample/code22'));
    }

    protected function code23()// CAPTCHA Mechanism
    {
        $this->getCode(__FILE__, 'code23');
        $this->view->set('form', $this->url('chapter2') . '?code=23&capcha=1');
        //<code23>
        if ($this->request->get('capcha')) {
            $capcha = rand(1111, 9999);
            $this->response->contentType('image/png');
            $im = @imagecreatetruecolor(64, 32);
            $textColor = imagecolorallocate($im, 233, 233, 233);
            imagestring($im, 6, 10, 8, $capcha, $textColor);
            imagepng($im);
            imagedestroy($im);
            $this->session->set('capcha', $capcha);
            return;
        } else if ($this->request->post('submit')) {
            // Is there anything wrong here?
            if ($this->request->post('capcha') == $this->session->get('capcha')) {
                $this->view->set('message', 'CAPCHA Match');
            } else {
                $this->view->set('error', 'CAPCHA Mismatch');
            }
        }
        //</code23>
        $this->view->set('result', $this->view->render('sample/code23'));
    }

    protected function code24()// Mitigating brute force attacks
    {
        $this->getCode(__FILE__, 'code24');
        $this->view->set('form', $this->url('chapter2') . '?code=24');
        // DDOS attack
        //<code24>
        $ip = $this->request->server('REMOTE_ADDR');
        $proxyIp = $this->request->server('HTTP_X_FORWARDED_FOR');
        $ip = $proxyIp ?: $ip;
        $uri = $this->request->server('REQUEST_URI');
        $statement = Database::getInstance()->prepare("SELECT COUNT(*) AS `cnt` FROM `accesslog` WHERE `ip`=? AND `url`=? AND `timestamp`>?");
        $statement->execute([$ip, $uri, time() - 5 * 60]);
        $count = $statement->fetch(\PDO::FETCH_ASSOC);
        $count = +$count['cnt'];
        if ($count > 5) {
            // stop processing request;
            $this->view->text('Too many request');
            exit;
            // Is there anything wrong?
        }
        $statement = Database::getInstance()->prepare("INSERT INTO `accesslog`(`ip`,`timestamp`,`url`)VALUES(?,?,?)");
        $statement->execute([$ip, time(), $uri]);
        // continue processing password
        //</code24>
        $this->view->set('result', $this->view->render('sample/code24'));
    }

    protected function code25()// Authentication Protocols (OAuth, OpenId, SAML, FIDO)
    {
        $this->view->set('link', [
            ['SAML', 'https://en.wikipedia.org/wiki/Security_Assertion_Markup_Language'],
            ['FIDO', 'https://fidoalliance.org/about/what-is-fido'],
            ['Google OpenIDConnect', 'https://developers.google.com/identity/protocols/OpenIDConnect'],
            ['Microsoft OpenID', 'https://docs.microsoft.com/en-us/azure/active-directory/develop/active-directory-protocols-openid-connect-code'],
            ['openid.net', 'http://openid.net/connect/'],
            ['OAuth for GitHub', 'https://developer.github.com/v3/oauth/']
        ]);
        $this->getCode(__FILE__, 'code25');
        //<code25>
        if ($this->request->post('authenticate') == 'github') {
            $gitHub = $this->config->gitHub;
            $this->response->redirect("https://github.com/login/oauth/authorize?client_id={$gitHub['client']}&redirect_uri={$gitHub['redirect']}&state={$gitHub['state']}");
            return;
        } elseif ($this->request->has('clearToken', Request::POST)) {
            $this->session->remove('gitHubToken');
        } elseif ($this->session->get('gitHubToken')) {
            $token = $this->session->get('gitHubToken');
            $this->view->set('token', $token);
            $client = new Client();
            $response = $client->request('GET', "https://api.github.com/user?access_token={$token}");
            $this->view->set('response', $response->getBody()->getContents());
        }
        //</code25>
        $this->view->set('result', $this->view->render('sample/code25'));
    }

    private function digestAuth($digestString, $credential, $realm)
    {
        $digestKeys = ['username', 'realm', 'nonce', 'uri', 'response', 'opaque', 'qop', 'nc', 'cnonce'];
        $digest = [];
        foreach ($digestKeys as $digestKey) {
            $qute = $digestKey == 'nc' || $digestKey == 'qop' ? '' : '"';
            $comma = $digestKey == 'cnonce' ? '' : ',';
            preg_match("/{$digestKey}={$qute}(?P<value>[^,]+){$qute}{$comma}/", $digestString, $match);
            if ($match) {
                $digest[$digestKey] = $match['value'];
            }
        }
        $user = $digest['username'];
        if ($user == $credential['username']) {
            $ha1 = md5("{$user}:{$realm}:{$credential['password']}");
            $ha2 = md5("{$this->request->server('REQUEST_METHOD')}:{$digest['uri']}");
            $validResponse = md5("{$ha1}:{$digest['nonce']}:{$digest['nc']}:{$digest['cnonce']}:{$digest['qop']}:{$ha2}");
            return $validResponse == $digest['response'];
        }
        return false;
    }
}