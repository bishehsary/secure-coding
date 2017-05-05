<?php


namespace FW\Util;


class Util
{
    public static function removeTag($code, $tag)
    {
        $filtered = self::removeInBetween($code, "<{$tag}>", "</{$tag}>");
        if ($filtered === false) {
            $filtered = self::removeInBetween($code, "&lt;{$tag}&gt;", "&lt;/{$tag}&gt;");
            if ($filtered === false) return $code;
        }
        return $filtered;
    }

    private static function removeInBetween($text, $startText, $endText)
    {
        $startIndex = strpos($text, $startText);
        if ($startIndex === false) return false;
        $endIndex = strpos($text, $endText);
        return substr($text, 0, $startIndex) . ($endIndex === false ? '' : substr($text, $endIndex + strlen($endText)));
    }
}