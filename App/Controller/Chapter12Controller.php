<?php

namespace App\Controller;

use FW\App\Model;

class Chapter12Controller extends Chapter
{
    protected function code73()// Event message structure
    {
        $this->view->set('form', $this->url('chapter12', null, 'code=73'));
        $this->getCode(__FILE__, 'code73');
        //<code73>
        if ($this->request->hasPost('log')) {
            $newValue = $this->request->post('name');
            $user = $this->session->get('user');
            // check if user has permission ? UPDATE : ERROR
            $statement = Model::$db->prepare("INSERT INTO `applog`(`type`,`date`,data)VALUES (?,?,?)");
            $statement->execute(['UPDATE', time(), json_encode([
                'user' => $user,
                'oldValue' => null,
                'newValue' => $newValue
            ])]);
            // actual update goes here
        }
        //</code73>
        $this->view->set('result', $this->view->render('sample/code73'));
    }

    protected function code74()// Logging best practices
    {
        $this->getCode(__FILE__, 'code74');
        //<code74>
        //</code74>
        $this->view->set('result', $this->view->render('sample/code74'));
    }
}