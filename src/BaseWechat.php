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
use Wailovet\Utils\File;
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

    protected function setData($key, $val)
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


    protected function cleanData()
    {
        $this->_data = array();
    }

    protected function mRequestPost($url, $data = array())
    {
        $this->_data = array_merge($this->_data, $data);
        $return_data = $this->requestPost($url);
        $this->cleanData();
        return $return_data;
    }

    protected function mRequestGet($url, $data = array())
    {
        $this->_data = array_merge($this->_data, $data);
        $return_data = $this->requestGet($url);
        $this->cleanData();
        return $return_data;
    }

    protected function requestUpload($url, $data = array(), $file_path)
    {
        $access_token = $this->access_token->get();
        $url .= "?access_token=$access_token";
        foreach ($data as $key => $val) {
            $url .= "&$key=$val";
        }

        $options['json'] = true;
        $options['files'] = array("media" => $file_path);
        $data = Error::check($this->http->post($url, $this->_data, $options)->getJsonToArray());
        $this->cleanData();
        return $data;
    }

    protected function requestDownload($url, $filename = '')
    {
        $params['access_token'] = $this->access_token->get();
        $params = array_merge($params, $this->_data);
        $contents = $this->http->get($url, $params)->getRequest();
        Error::check(json_decode($contents['data'], true));
        $ext = File::getStreamExt($contents['headers']);
        $filename = $filename ? $filename : md5($contents['data']) . $ext;
        file_put_contents($filename, $contents['data']);
        return $filename;
    }

}