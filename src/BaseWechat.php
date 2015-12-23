<?php
/**
 * Created by PhpStorm.
 * User: Wailovet
 * Date: 2015/12/21
 * Time: 15:13
 */

namespace Wailovet\wechat;

use Wailovet\Utils\Exception;
use Wailovet\Utils\Cache;
use Wailovet\Utils\Http;
use Wailovet\Utils\Error;

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


    protected $_data = array();

    protected function setData($key,$val)
    {
        $this->_data[$key] = $val;
        return $this;
    }

    protected function requestGet($url)
    {
        $params['access_token'] = $this->access_token->get();
        $params = array_merge($params, $this->_data);
        return Error::check($this->http->get($url, $params)->getJsonToArray());
    }

    protected function requestPost($url)
    {
        $access_token = $this->access_token->get();
        $url .= "?access_token=$access_token";

        $options['json'] = true;
        return Error::check($this->http->post($url, $this->_data, $options)->getJsonToArray());
    }


}