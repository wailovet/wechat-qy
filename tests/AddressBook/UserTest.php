<?php

/**
 * Created by PhpStorm.
 * User: Wailovet
 * Date: 2016/1/11
 * Time: 16:52
 */
use Wailovet\wechat\AddressBook\User;

class UserTest extends PHPUnit_Framework_TestCase
{

    public function testAll()
    {

        $corpid = 'wxf6a65243b40d13ac';
        $corpsecret = 'G_4BogDOqC-nyEmAbpCf9mRx6ZC9O176gYUZGJdau_ZTkftQlTE4NW9zwayiAORJ';

        $user = new User($corpid, $corpsecret);
        $senddata = array(
            "userid" => time() . rand(100, 999),
            "name" => time() . rand(100, 999),
            "weixinid" => "testss_sss" . rand(100, 999),
            "mobile" => time() . rand(100, 999),
            "position" => time() . rand(100, 999),
            "email" => time() . rand(100, 999) . "@qq.com");
        $user
            ->userid($senddata["userid"])
            ->name($senddata["name"])
            ->weixinid($senddata["weixinid"])
            ->mobile($senddata["mobile"])
            ->position($senddata["position"])
            ->email($senddata["email"])
            ->sex(User::SEX_MALE)
            ->create();

        $updatedata = array(
            "name" => time() . rand(100, 999),
            "mobile" => time() . rand(100, 999),
            "weixinid" => "testss_sss" . rand(100, 999),
            "position" => time() . rand(100, 999),
            "email" => time() . rand(100, 999) . "@qq.com");

        $data = $user->userid($senddata["userid"])->get();
        foreach ($senddata as $key => $val) {
            $this->assertTrue($data[$key] == $val);
        }

        $user
            ->userid($senddata["userid"])
            ->name($updatedata["name"])
            ->weixinid($updatedata["weixinid"])
            ->mobile($updatedata["mobile"])
            ->position($updatedata["position"])
            ->email($updatedata["email"])
            ->update();
        $data = $user->userid($senddata["userid"])->get();
        foreach ($updatedata as $key => $val) {
            $this->assertTrue($data[$key] == $val);
        }
        $user->userid($senddata["userid"])->delete();


        $user->simpleList();
        $user->fetchChild()->follow()->simpleList();
        $user->fetchChild()->notFollow()->detailedList();
        $user->fetchChild()->notFollow()->disabled()->detailedList();

        try {
            $user->userid($senddata["userid"])->get();
        } catch (Exception $e) {
            $this->assertTrue(true);
            return;
        }

        $this->assertTrue(false);

    }
}
