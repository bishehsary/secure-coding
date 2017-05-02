<?php

namespace App\Controller;

use FW\App\Acl;

class Chapter3Controller extends Chapter
{
    protected function code26()// Authorization models
    {
        $this->getCode(__FILE__, 'code26');
        $this->view->set('link', [['Access Control', 'https://www.owasp.org/index.php/Access_Control_Cheat_Sheet']]);
        //<code26>
        //</code26>
        $this->view->set('result', $this->view->render('sample/code26'));
    }

    protected function code27()// URL authorization
    {
        $this->getCode(__FILE__, 'code27');
        $id = 100;
        $this->view->set('deleteLink', $this->url('chapter3') . "?code=27&film=");
        $db = $this->database();
        //<code27>
        $movieId = $this->request->get('film');
        if ($movieId) {
            $statement = $db->prepare("DELETE FROM `film` WHERE film_id=?");
            // $statement->execute($movieId);
            // todo check if this actor owns this movie
            $this->view->set('deleted', true);
        }
        $statement = $db->prepare("SELECT * FROM `actor` WHERE `actor`.`actor_id`=?");
        $statement->execute([$id]);
        $this->view->set('actor', $statement->fetch(\PDO::FETCH_ASSOC));
        $statement = $db->prepare("SELECT `film`.`film_id`,title, release_year FROM `actor` 
LEFT JOIN `film_actor` ON (`actor`.`actor_id`=`film_actor`.`actor_id`)  
LEFT JOIN `film` ON (`film`.`film_id`=`film_actor`.`film_id`)  
WHERE `actor`.`actor_id`=?");
        $statement->execute([$id]);
        $movies = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $this->view->set('movies', $movies);
        //</code27>
        $this->view->set('result', $this->view->render('sample/code27'));
    }

    protected function code28()// File authorization
    {
        $this->getCode(__FILE__, 'code28');
        //<code28>
        //</code28>
        $this->view->set('result', $this->view->render('sample/code28'));
    }

    protected function code29()// Role Based Access Control (RBAC)
    {
        $this->getCode(__FILE__, 'code29');
        //<code29>
        //creating new role
        Acl::addRole('user');
        // assigning <resource, access> to the role
        Acl::allow('user', 'index', 'list');
        Acl::allow('user', 'account', 'view');
        Acl::allow('user', 'account', 'edit');
        //
        Acl::addRole('admin');
        Acl::allow('admin', '*', '*');
        //</code29>
        $this->view->set('result', $this->view->render('sample/code29'));
    }

    protected function code30()// Discretionary Access Control (DAC)
    {
        $this->getCode(__FILE__, 'code30');
        // Secures information by assigning sensitivity labels on information and comparing this to the level of
        // sensitivity a user is operating at
        //<code30>
        //</code30>
        $this->view->set('result', $this->view->render('sample/code30'));
    }

    protected function code31()// Mandatory Access Control (MAC)
    {
        $this->getCode(__FILE__, 'code31');
        //<code31>
        //</code31>
        $this->view->set('result', $this->view->render('sample/code31'));
    }

    protected function code32()// Permission Based Access Control
    {
        $this->getCode(__FILE__, 'code32');
        //<code32>
        //</code32>
        $this->view->set('result', $this->view->render('sample/code32'));
    }

    protected function code33()// Working with identities
    {
        $this->getCode(__FILE__, 'code33');
        //<code33>
        //</code33>
        $this->view->set('result', $this->view->render('sample/code33'));
    }

    protected function code34()// Claim based authorization
    {
        $this->getCode(__FILE__, 'code34');
        $this->view->set('link', [
            ['Claim Based Auth in .NET', 'https://www.future-processing.pl/blog/introduction-to-claims-based-authentication-and-authorization-in-net/']
        ]);
        //<code34>
        //</code34>
        $this->view->set('result', $this->view->render('sample/code34'));
    }

    protected function code35()// Role manager
    {
        $this->getCode(__FILE__, 'code35');
        //<code35>

        //</code35>
        $this->view->set('result', $this->view->render('sample/code35'));
    }

    protected function code36()// MVC Authorization
    {
        $this->getCode(__FILE__, 'code36');
        //<code36>
        //</code36>
        $this->view->set('result', $this->view->render('sample/code36'));
    }
}