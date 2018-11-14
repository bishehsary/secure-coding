<?php


use PHPUnit\Framework\TestCase;

class UtilTest extends TestCase
{
    function testParse()
    {
        $fileInfo = pathinfo('chapter8/file/9f357b2d-00b6-460b-bf2a-f7006e99a7ba');
        $this->assertEquals('9f357b2d-00b6-460b-bf2a-f7006e99a7ba', $fileInfo['filename']);
        $this->assertTrue(true);
    }
}
