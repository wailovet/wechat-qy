<?php
/**
 * Created by PhpStorm.
 * User: Wailovet
 * Date: 2015/12/21
 * Time: 15:13
 */

namespace Wailovet\wechat\AddressBook;

use Wailovet\Utils\Exception;
use Wailovet\wechat\BaseWechat;

class Department extends BaseWechat
{
    const DEPARTMENT_CREATE_API = "https://qyapi.weixin.qq.com/cgi-bin/department/create";
    const DEPARTMENT_UPDATE_API = "https://qyapi.weixin.qq.com/cgi-bin/department/update";
    const DEPARTMENT_DELETE_API = "https://qyapi.weixin.qq.com/cgi-bin/department/delete";
    const DEPARTMENT_LIST_API = "https://qyapi.weixin.qq.com/cgi-bin/department/list";


    public function create($data = array())
    {
        if (!isset($this->_data['parentid']) && !isset($data['parentid'])) {
            $this->_data['parentid'] = 1;
        }
        return $this->mRequestPost(self::DEPARTMENT_CREATE_API, $data);
    }

    public function update($data = array())
    {
        return $this->mRequestPost(self::DEPARTMENT_UPDATE_API, $data);
    }

    public function delete($data = array())
    {
        return $this->mRequestGet(self::DEPARTMENT_DELETE_API, $data);
    }

    public function get($data = array())
    {
        $data_list = $this->mRequestGet(self::DEPARTMENT_LIST_API, $data);
        return $data_list;
    }


    public function data($data)
    {
        $this->_data = $data;
        return $this;
    }

    public function name($name)
    {
        $this->setData('name', $name);
        return $this;
    }

    public function parentid($parentid)
    {
        $this->setData('parentid', $parentid);
        return $this;
    }

    public function order($order)
    {
        $this->setData('order', $order);
        return $this;
    }

    public function id($id)
    {
        $this->setData('id', $id);
        return $this;
    }


}