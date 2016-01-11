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
            "weixinid" => time() . rand(100, 999),
            "mobile" => time() . rand(100, 999),
            "position" => time() . rand(100, 999),
            "email" => time() . rand(100, 999));
        $user
            ->userid($senddata["userid"])
            ->name($senddata["name"])
            ->weixinid($senddata["weixinid"])
            ->mobile($senddata["mobile"])
            ->position($senddata["position"])
            ->email($senddata["email"])
            ->sex(User::SEX_MALE)
            ->create();
        $data = $user->userid($senddata["userid"])->get();
        foreach($senddata as $key => $val){
            $this->assertTrue($data[$key] == $val);
        }
    }
}
