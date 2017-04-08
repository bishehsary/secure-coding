<?php

namespace App\Controller;


use App\Model\Heading;
use FW\App\Controller;

abstract class Chapter extends Controller
{

    function indexAction()
    {
        $code = +$_GET['code'];
        $heading = Heading::findById($code);
        $parent = Heading::findById($heading->parent);
        $this->view->set('h1', $parent->title);
        $this->view->set('h2', $heading->title);
        $this->view->set('title', $heading->title);
        // calling sample code
        $this->{"code${code}"}();
        // generating prev & next links
        $next = Heading::find(['id' => $heading->id + 1, 'parent' => $parent->id]);
        if ($next) {
            $this->view->set('next', "?controller=chapter{$parent->id}&code={$next[0]['id']}");
        }
        $prev = Heading::find(['id' => $heading->id - 1, 'parent' => $parent->id]);
        if ($prev) {
            $this->view->set('prev', "?controller=chapter{$parent->id}&code={$prev[0]['id']}");
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