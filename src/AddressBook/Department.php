<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/21
 * Time: 15:13
 */

namespace Wailovet\wechat\AddressBook;


use Wailovet\Utils\Error;
use Wailovet\Utils\Exception;
use Wailovet\wechat\BaseWechat;

class Department extends BaseWechat
{
    const DEPARTMENT_CREATE_API = "https://qyapi.weixin.qq.com/cgi-bin/department/create";
    const DEPARTMENT_UPDATE_API = "https://qyapi.weixin.qq.com/cgi-bin/department/update";
    const DEPARTMENT_DELETE_API = "https://qyapi.weixin.qq.com/cgi-bin/department/delete";
    const DEPARTMENT_LIST_API = "https://qyapi.weixin.qq.com/cgi-bin/department/list";


    private $data = array();

    public function data($data)
    {
        $this->data = $data;
        return $this;
    }

    public function create($data = array())
    {
        $this->data = array_merge($this->data, $data);
        if(!isset($this->data['parentid'])){
            $this->data['parentid'] = 1;
        }
        return $this->request_post(self::DEPARTMENT_CREATE_API);
    }

    public function name($name)
    {
        $this->data['name'] = $name;
        return $this;
    }

    public function parentid($parentid)
    {
        $this->data['parentid'] = $parentid;
        return $this;
    }

    public function order($order)
    {
        $this->data['order'] = $order;
        return $this;
    }

    public function id($id)
    {
        $this->data['id'] = $id;
        return $this;
    }


    public function update($data = array())
    {
        $this->data = array_merge($this->data, $data);
        return $this->request_post(self::DEPARTMENT_UPDATE_API);
    }

    public function delete($data = array())
    {
        $this->data = array_merge($this->data, $data);
        return $this->request_get(self::DEPARTMENT_DELETE_API);
    }

    public function get($data = array())
    {
        $this->data = array_merge($this->data, $data);
        return $this->request_get(self::DEPARTMENT_LIST_API);
    }


    private function request_get($url)
    {
        $params['access_token'] = $this->access_token->get();
        $params = array_merge($params, $this->data);
        return Error::check($this->http->get($url, $params)->getJsonToArray());
    }

    private function request_post($url)
    {
        $access_token = $this->access_token->get();
        $url .= "?access_token=$access_token";

        $options['json'] = true;
        return Error::check($this->http->post($url, $this->data,$options)->getJsonToArray());
    }


}