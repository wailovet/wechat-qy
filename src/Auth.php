<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/21
 * Time: 15:13
 */

namespace Wailovet\wechat;


use Wailovet\Utils\Error;
use Wailovet\Utils\Exception;
use Wailovet\Utils\Request;


class Auth extends BaseWechat
{

    const CORP_AUTH_URL = 'https://open.weixin.qq.com/connect/oauth2/authorize';
    const CORP_USERID_URL = 'https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo';
    const CORP_USERINFO_URL = 'https://qyapi.weixin.qq.com/cgi-bin/user/get';


    private function getUserIdFromCode($code)
    {
        $access_token = $this->access_token->get();
        $data = $this->http->get(self::CORP_USERID_URL . "?access_token=$access_token&code=$code")->getJsonToArray();
        return Error::check($data);
    }

    private function getUserFromCode($userid)
    {
        $access_token = $this->access_token->get();
        $data = $this->http->get(self::CORP_USERINFO_URL . "?access_token=$access_token&userid=$userid")->getJsonToArray();
        return Error::check($data);
    }

    /**
     * 获取已授权用户
     *
     */
    private function user()
    {
        $user = $this->userId();
        if (empty($user['UserId'])) {
            return $user;
        }
        return $this->getUserFromCode($user['UserId']);
    }

    /**
     * 获取已用户ID
     *
     */
    private function userId()
    {
        $code = Request::get('code');
        return $this->getUserIdFromCode($code);
    }


    /**
     * 通过授权获取用户
     *
     * @param string $to
     * @param string $state
     */
    public function authorize($to = null, $state = 'STATE')
    {

        if (!Request::get('state') && !Request::get('code')) {
            $this->redirect($to, $state);
        }
        if($this->only_userid){
            return $this->userId();
        }
        return $this->user();
    }


    private $only_userid = false;
    public function onlyUserid()
    {
        $this->only_userid = true;
        return $this;
    }

    /**
     * 获取当前URL
     *
     * @return string
     */
    private function currentUrl()
    {
        $protocol = (!empty($_SERVER['HTTPS'])
            && $_SERVER['HTTPS'] !== 'off'
            || $_SERVER['SERVER_PORT'] === 443) ? 'https://' : 'http://';
        if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
            $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
        } else {
            $host = $_SERVER['HTTP_HOST'];
        }
        return $protocol . $host . $_SERVER['REQUEST_URI'];
    }

    private function makeUrl($to = null, $state = 'STATE')
    {
        if (empty($to)) {
            $to = $this->currentUrl();
        }
        return self::CORP_AUTH_URL . '?appid=' . $this->corpid . '&redirect _uri=' . $to . '&response_type=code&scope=snsapi_base&state=' . $state . '#wechat_redirect';
    }

    /**
     * 直接跳转
     *
     * @param string $to
     * @param string $scope
     * @param string $state
     */
    private function redirect($to = null, $state = 'STATE')
    {
        header('Location:' . $this->makeUrl($to, $state));
        exit;
    }
}