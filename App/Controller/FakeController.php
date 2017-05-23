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

    function frameAction()
    {
        $this->view->html('<iframe src="http://sc.io/secode"></iframe>');
    }

    function redirectAction()
    {
        if ($this->request->hasGet('redirect')) {
            $this->view->html('<h1 class="text-center text-danger">Gotcha!!!</h1>');
        } else {
            $this->response->redirect("http://sc.io/account/relogin?url=http://fake.io/fake/redirect");
        }
    }

    function clickjackingAction()
    {
        $this->view->html($this->view->render('fake/clickjacking'));
    }
}