<?php

namespace App\Controller;

use App\Model\Heading;
use FW\App\Controller;

class IndexController extends Controller
{
    function indexAction()
    {
        // splash
        $this->renderMater($this->view->render('index/index'), 0);
    }

    function whoamiAction()
    {
        $this->renderMater($this->view->render('index/whoami'), 1);
    }

    function whoruAction()
    {
        $this->renderMater($this->view->render('index/whoami'), 2);
    }

    function playgroundAction()
    {
        // xampp > mysql
        // redis > docker
        // nodejs
        // gulp > server restart
        // composer
        $this->renderMater($this->view->render('index/playground'), 3);
    }

    function frameworkAction()
    {
        // Config
        // index.php
        // App.php, controller, view, session, request, response
        $this->renderMater($this->view->render('index/framework'), 4);
    }

    function infoAction()
    {
        $this->view->startBuffering();
        phpinfo();
        $this->view->set('info', $this->view->stopBuffering());
        $this->renderMater($this->view->render('index/info'), 5);
    }

    function iniAction()
    {
        $iniFile = "c:/xampp/php/php.ini";
        $this->view->set('ini', htmlentities(file_get_contents($iniFile)));
        $this->renderMater($this->view->render('index/ini'), 6);
    }

    function headingAction()
    {
        $chapters = Heading::find(['parent' => 0]);
        $grands = [];
        foreach ($chapters as $index => $chapter) {
            $children = Heading::find(['parent' => $chapter['id']]);
            $chapter['children'] = [];
            foreach ($children as $child) {
                $chapter['children'][] = $child;
            }
            $grands[] = $chapter;
        }
        $this->view->set('headings', $grands);
        $this->renderMater($this->view->render('index/headings'), 7);
    }

    private function renderMater($content, $index)
    {
        $pages = [
            ['Splash', 'index/index'],
            ['Who Am I', 'index/whoami'],
            ['Who R U', 'index/whoru'],
            ['Playground', 'index/playground'],
            ['Framework', 'index/framework'],
            ['phpinfo()', 'index/info'],
            ['php.ini file', 'index/ini'],
            ['Topics', 'index/heading'],
        ];
        if (isset($pages[$index - 1])) {
            $this->view->set('prev', $pages[$index - 1]);
        }
        if (isset($pages[$index + 1])) {
            $this->view->set('next', $pages[$index + 1]);
        }
        $this->view->set('title', $pages[$index][0]);
        $this->view->set('content', $content);
        $this->view->html($this->view->render('index/master'));
    }
}