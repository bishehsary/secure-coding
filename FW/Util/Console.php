<?php

namespace FW\Util;

class Console
{
    static function log($data)
    {
        file_put_contents('php://stdout', $data);
    }
}