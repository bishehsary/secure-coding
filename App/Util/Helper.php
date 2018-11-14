<?php

namespace App\Util;

class Helper
{
    static function fDate($timestamp)
    {
        return $timestamp ? date('Y-m-d H:i:s', $timestamp) : '-';
    }
}