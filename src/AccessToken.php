<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/21
 * Time: 14:21
 */

namespace Wailovet\wechat;

use Wailovet\Utils\Http;
use Wailovet\Utils\Cache;

class AccessToken
{
    private $http;
    private $corpid;
    private $corpsecret;
    const API_TOKEN_GET = 'https://qyapi.weixin.qq.com/cgi-bin/gettoken';
    public function __construct($corpid, $corpsecret)
    {
        $this->corpid = $corpid;
        $this->corpsecret = $corpsecret;
        $this->cache = new Cache($corpid);
        $this->http = new Http();
    }

    public function get($forceRefresh = false)
    {
        $access_token = $this->cache->get("access_token");
        if ($forceRefresh ||empty($access_token)) {
            $data = $this->getTokenFromServer();
            $access_token = $data['access_token'];
            $this->cache->set("access_token",$data['access_token'],$data['expires_in'] - 800);
        }
        return $access_token;
    }


    /**
     * Get the access token from WeChat server.
     *
     * @param string $cacheKey
     *
     * @return array|bool
     */
    protected function getTokenFromServer()
    {
        $params = array(
            'corpid'      => $this->corpid,
            'corpsecret'     => $this->corpsecret
        );
        $token = $this->http->get(self::API_TOKEN_GET, $params)->getJsonToArray();
        return Error::check($token);
    }
}