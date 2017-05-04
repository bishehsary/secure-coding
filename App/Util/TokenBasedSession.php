<?php


namespace App\Util;


use FW\App\Config;
use PHPUnit\Runner\Exception;
use Predis\Client;

class TokenBasedSession
{
    const Err_TOKEN = 1;
    const Err_RESTRICTION = 2;
    const Err_EXPIRY = 3;

    private $db;
    private $data = [];
    private $token;
    private $enforceRestriction = false;

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
            if (!$this->data) {
                return self::Err_TOKEN;
            }
            // key does not exist || last visit time is not set
            if (!$this->data || ($this->data && !isset($this->data['visit']))) {
                return self::Err_EXPIRY;
            }
            // session timeout
            if (time() - $this->data['visit'] > Config::getInstance()->security['sessionTimeout']) {
                return self::Err_EXPIRY;
            }
            if ($this->enforceRestriction && !$this->checkRestriction()) {
                // it depends on your business logic
                return self::Err_RESTRICTION;
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
        if ($this->enforceRestriction) {
            $this->data['restriction'] = $this->generateRestriction();
        }
    }

    private function fetch()
    {
        return $this->db->get($this->token);
    }

    private function save()
    {
        return $this->db->set($this->token, json_encode($this->data));
    }

    private function checkRestriction()
    {
        $restriction = $this->generateRestriction();
        return isset($this->data['restriction']) && $restriction == $this->data['restriction'];
    }

    private function generateRestriction()
    {
        return md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
    }
}