<?php

/**
 * Created by PhpStorm.
 * User: Wailovet
 * Date: 2016/1/11
 * Time: 11:58
 */
use Wailovet\wechat\Media;
class MediaTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
    }

    public function tearDown()
    {
    }

    public function testIsInit()
    {
        // test to ensure that the object from an fsockopen is valid

        require_once(dirname(__FILE__)."/../autoload.php");

        $corpid  = 'wxf6a65243b40d13ac';
        $corpsecret = 'G_4BogDOqC-nyEmAbpCf9mRx6ZC9O176gYUZGJdau_ZTkftQlTE4NW9zwayiAORJ';

        $media = new Media($corpid,$corpsecret);
        $this->assertTrue(!empty($media));
    }
}
