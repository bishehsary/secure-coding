<?php

namespace App\Controller;

class Chapter2Controller extends Chapter
{
    protected function code20()// Authentication Scenarios
    {
        $this->getCode(__FILE__, 'code20');
        //<code20>
        //</code20>
        $this->view->set('result', $this->view->render('sample/code20'));
    }

    protected function code21()// Implementing form authentication
    {
        $this->getCode(__FILE__, 'code21');
        // $validator = new Validator([
        //     ['username' => [Validator::MIN_LENGTH => 4, Validator::MAX_LENGTH => 7, Validator::MATCH => "/^\w[\w\d]+$/i"]],
        //     ['password' => [Validator::MIN_LENGTH => 5, Validator::MAX_LENGTH => 10]]
        // ]);
        // $result = $validator->validate($_POST);
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
                // enumeration warning!
                $this->view->set('error', 'Wrong username/password combination');
            }
        } elseif ($this->request->post('logout')) {
            $this->session->destroy();
            // watch out!
            $this->view->set('user', null);
        }
        //</code21>
        // if ($username && strlen($username) >= 4 && strlen($username) <= 8 && preg_match("/^\w[\w\d]+$/i", $username)) {
        //     if ($password && strlen($password) >= 5 && strlen($password) <= 10) {
        //         // query
        //     } else {
        //         $errors['password'] = true;
        //     }
        // } else {
        //     $errors['username'] = true;
        // }
        /**
         * <script>
         * let form = document.querySelector('form[name=loginForm]');
         * let userInput = document.getElementById('username');
         * let passInput = document.getElementById('password');
         * form.addEventListener('submit', event => {
         * let username = userInput.value;
         * let password = passInput.value;
         * userInput.parentElement.classList.remove('has-error');
         * passInput.parentElement.classList.remove('has-error');
         * let isValid = true;
         * if (8 < username.length || username.length < 4 || !/^\w[\w\d]+$/i.exec(username)) {
         * isValid = false;
         * userInput.parentElement.classList.add('has-error');
         * }
         * if (10 < password.length || password.length < 5) {
         * isValid = false;
         * passInput.parentElement.classList.add('has-error');
         * }
         * if (!isValid) {
         * event.preventDefault();
         * return false;
         * }
         * }, false);
         * </script>
         */
        $this->view->set('result', $this->view->render('sample/code21'));
    }

    protected function code22()// Password Control
    {
        $this->getCode(__FILE__, 'code22');
        //<code22>
        //</code22>
        $this->view->set('result', $this->view->render('sample/code22'));
    }

    protected function code23()// CAPTCHA Mechanism
    {
        $this->getCode(__FILE__, 'code23');
        //<code23>
        //</code23>
        $this->view->set('result', $this->view->render('sample/code23'));
    }

    protected function code24()// Mitigating brute force attacks
    {
        $this->getCode(__FILE__, 'code24');
        //<code24>
        //</code24>
        $this->view->set('result', $this->view->render('sample/code24'));
    }

    protected function code25()// Authentication Protocols (OAuth, OpenId, SAML, FIDO)
    {
        $this->getCode(__FILE__, 'code25');
        //<code25>
        //</code25>
        $this->view->set('result', $this->view->render('sample/code25'));
    }
}