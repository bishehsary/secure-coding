<?php


namespace App\Util;


use FW\App\Config;
use PHPUnit\Runner\Exception;
use Predis\Client;

class TokenBasedSession
{
    private $db;
    private $data = [];
    private $token;

    function __construct($server, $port = 6379)
    {
        try {
            $this->db = new Client(['host' => $server]);
        } catch (Exception $e) {
            var_dump($e);
        }
    }

    function init($token = null)
    {
        if ($token) {
            $this->token = $token;
            $this->data = json_decode($this->fetch(), true);
            // key does not exist || last visit time is not set
            if (!$this->data || ($this->data && !isset($this->data['visit']))) {
                return false;
            }
            // session timeout
            if (time() - $this->data['visit'] > Config::getInstance()->security['sessionTimeout']) {
                return false;
            }
        } else {
            $this->generateToken();
        }
        // updating last visit time
        $this->set('visit', time());
        return true;
    }

    function set($name, $value)
    {
        $this->data[$name] = json_encode($value);
        $this->save();
    }

    function get($name, $defaultValue = null)
    {
        $value = isset($this->data[$name]) ? $this->data[$name] : $defaultValue;
        $this->save();
        return $value;
    }

    function remove($name)
    {
        unset($this->data[$name]);
        $this->save();
    }

    function getToken()
    {
        return $this->token;
    }

    function destroy()
    {
        $this->data = [];
        $result = $this->db->del($this->token) == 1;
        $this->token = null;
        return $result;
    }

    private function generateToken()
    {
        $this->token = bin2hex(random_bytes(32));
    }

    private function fetch()
    {
        return $this->db->get($this->token);
    }

    private function save()
    {
        return $this->db->set($this->token, json_encode($this->data));
    }
}