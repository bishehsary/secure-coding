<?php

namespace App\Controller;

class Chapter5Controller extends Chapter
{
    protected function code45()// Data Validation Strategies
    {
        $this->getCode(__FILE__, 'code45');
        // $validator = new Validator([
        //     ['username' => [Validator::MIN_LENGTH => 4, Validator::MAX_LENGTH => 7, Validator::MATCH => "/^\w[\w\d]+$/i"]],
        //     ['password' => [Validator::MIN_LENGTH => 5, Validator::MAX_LENGTH => 10]]
        // ]);
        // $result = $validator->validate($this->>request->post());
        //<code45>
        //</code45>
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
        $this->view->set('result', $this->view->render('sample/code45'));
    }

    protected function code46()// Sanitize with Whitelist
    {
        $this->getCode(__FILE__, 'code46');
        //<code46>
        //</code46>
        $this->view->set('result', $this->view->render('sample/code46'));
    }

    protected function code47()// Sanitize with Blacklist
    {
        $this->getCode(__FILE__, 'code47');
        //<code47>
        //</code47>
        $this->view->set('result', $this->view->render('sample/code47'));
    }

    protected function code48()// Implement Validator
    {
        $this->getCode(__FILE__, 'code48');
        //<code48>
        //</code48>
        $this->view->set('result', $this->view->render('sample/code48'));
    }
}