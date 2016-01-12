<?php

/**
 * Created by PhpStorm.
 * User: Wailovet
 * Date: 2016/1/11
 * Time: 16:52
 */
use Wailovet\wechat\AddressBook\Tag;
use Wailovet\wechat\AddressBook\User;

class TagTest extends PHPUnit_Framework_TestCase
{

    public function testAll()
    {

        $corpid = 'wxf6a65243b40d13ac';
        $corpsecret = 'G_4BogDOqC-nyEmAbpCf9mRx6ZC9O176gYUZGJdau_ZTkftQlTE4NW9zwayiAORJ';

        $tag = new Tag($corpid, $corpsecret);
        $user = new User($corpid, $corpsecret);

        $name = time() . rand(100, 999);
        $data = $tag->name($name)->create();
        $tagid = $data['tagid'];

        $data = $tag->lists();

        $b = false;
        for ($i = 0; $i < count($data['taglist']); $i++) {
            if ($data['taglist'][$i]['tagid'] == $tagid && $data['taglist'][$i]['tagname'] == $name) {
                $b = true;
            }
        }
        $this->assertTrue($b);

        $name = time() . rand(100, 999);
        $tag->id($tagid)->update(array("name" => $name));
        $data = $tag->lists();
        $b = false;
        for ($i = 0; $i < count($data['taglist']); $i++) {
            if ($data['taglist'][$i]['tagid'] == $tagid && $data['taglist'][$i]['tagname'] == $name) {
                $b = true;
            }
        }
        $this->assertTrue($b);

        $wxid = "testss_sss" . rand(100, 999);
        $user->weixinid($wxid)->userid($name)->name($name)->create();
        $tag->id($tagid)->user($name)->add();

        $data = $tag->id($tagid)->get();


        $b = false;
        for ($i = 0; $i < count($data['userlist']); $i++) {
            if ($data['userlist'][$i]['userid'] == $name && $data['userlist'][$i]['name'] == $name) {
                $b = true;
            }
        }
        $this->assertTrue($b);

        $tag->id($tagid)->user($name)->delete();

        $tag->id($tagid)->delete();

    }
}
