<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/21
 * Time: 15:13
 */

namespace Wailovet\wechat;

use Wailovet\Utils\Exception;
use Wailovet\Utils\Cache;
use Wailovet\Utils\Http;

class BaseWechat
{
    protected $http;
    protected $corpid;
    protected $corpsecret;
    protected $access_token;

    public function __construct($corpid, $corpsecret)
    {
        $this->corpid = $corpid;
        $this->corpsecret = $corpsecret;
        $this->cache = new Cache($corpid);
        $this->http = new Http();
        $this->access_token = new AccessToken($this->corpid, $this->corpsecret);
    }


}