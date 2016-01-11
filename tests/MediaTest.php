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
    private $media;

    public function setUp()
    {
        $corpid = 'wxf6a65243b40d13ac';
        $corpsecret = 'G_4BogDOqC-nyEmAbpCf9mRx6ZC9O176gYUZGJdau_ZTkftQlTE4NW9zwayiAORJ';

        $this->media = new Media($corpid, $corpsecret);
    }

    public function tearDown()
    {
    }

    public function testIsInit()
    {
        // test to ensure that the object from an fsockopen is valid
        $this->assertTrue(!empty($this->media));
    }

    public function testCount()
    {
        $data = $this->media->count(0);
        $this->assertTrue($data['errcode'] === 0);
    }


    public function testAll()
    {
        $media = $this->media;
        file_put_contents(dirname(__FILE__) . "/test.txt", "test");
        $data = $media->file(dirname(__FILE__) . "/test.txt")->type(Media::TYPE_FILE)->upload();
        $this->assertTrue($data['type'] == "file" && !empty($data['media_id']));
        $media_id = $data['media_id'];
        $media->id($media_id)->download(dirname(__FILE__) . "/test2.txt");
        $test2 = file_get_contents(dirname(__FILE__) . "/test2.txt");
        $this->assertTrue($test2 == "test");
    }
}
