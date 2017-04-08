<?php

namespace App\Controller;


class FakeController extends Chapter
{

    function indexAction()
    {
        $this->view->set('title', 'Fake Website');
        $this->view->html($this->view->render('fake/fake'));
    }

    function csrfAction()
    {
        $this->view->html($this->view->render('fake/csrf'));
    }
}