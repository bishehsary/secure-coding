<?php

namespace App\Controller;

use FW\App\Validator;

class Chapter5Controller extends Chapter
{
    protected function code45()// Data Validation Strategies
    {
        $this->getCode(__FILE__, 'code45');
        //<code45>
        //</code45>
        $this->view->set('result', $this->view->render('sample/code45'));
    }

    protected function code46()// Sanitize with Whitelist
    {
        $this->getCode(__FILE__, 'code46');
        //<code46>
        if (($theme = $this->request->post('theme'))) {
            $this->view->set('theme', $this->view->render("fake/{$theme}"));
        }
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
        // $validator = new Validator([
        //     ['username' => [Validator::MIN_LENGTH => 4, Validator::MAX_LENGTH => 7, Validator::MATCH => "/^\w[\w\d]+$/i"]],
        //     ['password' => [Validator::MIN_LENGTH => 5, Validator::MAX_LENGTH => 10]]
        // ]);
        // $result = $validator->validate($this->request->post());
        //<code48>
        $username = $this->request->post('username');
        $password = $this->request->post('password');
        if ($username && strlen($username) >= 4 && strlen($username) <= 8 && preg_match("/^\w[\w\d]+$/i", $username)) {
            if ($password && strlen($password) >= 5 && strlen($password) <= 10) {
                // query
            } else {
                $errors['password'] = true;
            }
        } else {
            $errors['username'] = true;
        }
        //</code48>
        $this->view->set('result', $this->view->render('sample/code48'));
    }
}