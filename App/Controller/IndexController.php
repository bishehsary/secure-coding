<?php

namespace App\Controller;

use App\Model\Heading;
use FW\App\Controller;

class IndexController extends Controller
{
    function indexAction()
    {
        $this->renderMater($this->view->render('index/splash'), 0);
    }

    function whoamiAction()
    {
        $this->renderMater($this->view->render('index/whoami'), 1);
    }

    function whoruAction()
    {
        $this->renderMater($this->view->render('index/whoru'), 2);
    }

    function playgroundAction()
    {
        $this->view->set('composer', file_get_contents($this->config->root . '/composer.json'));
        $this->view->set('json', file_get_contents($this->config->root . '/package.json'));
        $this->renderMater($this->view->render('index/playground'), 3);
    }

    function frameworkAction()
    {
        $root = $this->config->root;
        $this->view->set('codes', [
            ['/App/config/config.php', file_get_contents("{$root}/App/config/config.php")],
            ['/index.index', file_get_contents("{$root}/index.php")],
            ['\FW\App\Config', file_get_contents("{$root}/FW/App/Config.php")],
            ['\FW\App\App', file_get_contents("{$root}/FW/App/App.php")],
            ['\FW\App\Controller', file_get_contents("{$root}/FW/App/Controller.php")],
            ['\FW\App\View', file_get_contents("{$root}/FW/App/View.php")],
            ['\FW\App\Request', file_get_contents("{$root}/FW/App/Request.php")],
            ['\FW\App\Response', file_get_contents("{$root}/FW/App/Response.php")],
        ]);
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
        $iniFile = "C:/php7.1.7-vc14-nts/x64/php.ini";
        $this->view->set('ini', htmlentities(file_get_contents($iniFile)));
        $this->renderMater($this->view->render('index/ini'), 6);
    }

    function headingAction()
    {
        $chapters = Heading::find(['parent' => 0]);
        $grands = [];
        $this->view->set('total', Heading::find([], ['COUNT(*) AS `cnt`'])[0]['cnt']);
        foreach ($chapters as $index => $chapter) {
            $children = Heading::find(['parent' => $chapter['id'], 'done' => 0]);
            $chapter['children'] = [];
            foreach ($children as $child) {
                $chapter['children'][] = $child;
            }
            $grands[] = $chapter;
        }
        $this->view->set('headings', $grands);
        $this->renderMater($this->view->render('index/headings'), 7);
    }

    function progressAction()
    {
        $action = $this->request->post('action', '');
        $response = [];
        if ($action) {
            switch ($action) {
                case 'complete':
                    $id = +$this->request->post('id');
                    $heading = new Heading();
                    $response['result'] = $heading->markAsDone($id);
                    break;
            }
            $this->response->json($response);
        }
    }

    private function renderMater($content, $index)
    {
        $pages = [
            ['', 'index/index'],
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