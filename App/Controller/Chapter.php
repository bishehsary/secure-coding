<?php

namespace App\Controller;


use App\Model\Heading;
use FW\App\Controller;

abstract class Chapter extends Controller
{

    function indexAction()
    {
        $code = $this->request->get('code', 0);
        $heading = Heading::findById($code);
        if (!$heading) {
            $this->notFoundPage("Heading not found");
            return;
        }
        $parent = Heading::findById($heading->parent);
        $this->view->set('h1', $parent->title);
        $this->view->set('h2', $heading->title);
        $this->view->set('title', $heading->title);
        // calling sample code
        $this->{"code${code}"}();
        // generating prev & next links
        $items = Heading::find(['parent' => $parent->id]);
        $nextId = $prevId = 0;
        foreach ($items as $item) {
            if ($item['id'] < $heading->id) {
                $prevId = $item['id'];
            } else if ($item['id'] > $heading->id) {
                $nextId = $item['id'];
                break;
            }
        }
        if ($nextId) {
            $this->view->set('next', "?controller=chapter{$parent->id}&code={$nextId}");
        }
        if ($prevId) {
            $this->view->set('prev', "?controller=chapter{$parent->id}&code={$prevId}");
        }
        // rendering view
        $this->view->html($this->view->render('code'));
    }

    protected function getCode($file, $tplName)
    {
        $server = file_get_contents($file);
        $startTag = "//<{$tplName}>";
        $startIndex = strpos($server, $startTag) + strlen($startTag);
        $endIndex = strpos($server, "//</{$tplName}>");
        $length = $endIndex - $startIndex;
        $serverCode = substr($server, $startIndex, $length);
        $this->view->set('serverCode', htmlentities($serverCode));
        $tplFile = __DIR__ . '/../View/templates/sample/' . $tplName . '.phtml';
        if (file_exists($tplFile)) {
            $this->view->set('clientCode', htmlentities(file_get_contents($tplFile)));
        }
    }
}