<?php

namespace App\Controller;


use App\Model\Heading;
use FW\App\Controller;
use FW\App\Database;
use FW\Util\Util;

abstract class Chapter extends Controller
{
    private static $pdo;
    private static $mysqli;
    private $dbConfig = [
        'dbms' => 'mysql',
        'database' => 'sakila',
        'host' => '192.168.99.100',
        'port' => 3306,
        'username' => 'root',
        'password' => '',
        'generateSchema' => false
    ];

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
            $this->view->set('next', Util::genUrl("chapter{$parent->id}") . "?code={$nextId}");
        }
        if ($prevId) {
            $this->view->set('prev', Util::genUrl("chapter{$parent->id}") . "?code={$prevId}");
        }
        // rendering view
        $this->view->html($this->view->render('code'));
    }

    /**
     * @return \PDO
     */
    protected function pdo()
    {
        $key = 'sakila';
        if (!self::$pdo) {
            Database::init($this->dbConfig, $key);
            self::$pdo = Database::getInstance($key);
        }
        return self::$pdo;
    }

    /**
     * @return \mysqli
     */
    protected function mysqli()
    {
        $dbConfig = $this->dbConfig;
        if (!self::$mysqli) {
            self::$mysqli = new \mysqli($dbConfig['host'], $dbConfig['username'], null, $dbConfig['database']);
        }
        return self::$mysqli;
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