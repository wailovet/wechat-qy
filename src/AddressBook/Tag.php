<?php
/**
 * Created by PhpStorm.
 * User: Wailovet
 * Date: 2015/12/23
 * Time: 10:17
 */

namespace Wailovet\wechat\AddressBook;

use Wailovet\wechat\BaseWechat;

class Tag extends BaseWechat
{

    const TAG_CREATE_API = 'https://qyapi.weixin.qq.com/cgi-bin/tag/create';
    const TAG_UPDATE_API = 'https://qyapi.weixin.qq.com/cgi-bin/tag/update';
    const TAG_DELETE_API = 'https://qyapi.weixin.qq.com/cgi-bin/tag/delete';
    const TAG_LIST_API = 'https://qyapi.weixin.qq.com/cgi-bin/tag/list';
    const TAG_ADD_USER_API = 'https://qyapi.weixin.qq.com/cgi-bin/tag/addtagusers';
    const TAG_GET_USER_API = 'https://qyapi.weixin.qq.com/cgi-bin/tag/get';
    const TAG_DEL_USER_API = 'https://qyapi.weixin.qq.com/cgi-bin/tag/deltagusers';


    public function create($data = array())
    {
        return $this->mRequestPost(self::TAG_CREATE_API, $data);
    }


    public function update($data = array())
    {
        return $this->mRequestPost(self::TAG_UPDATE_API, $data);
    }

    public function delete($data = array())
    {
        if (empty($this->_data['partylist']) && empty($this->_data['userlist'])) {
            return $this->mRequestGet(self::TAG_DELETE_API, $data);
        }
        return $this->mRequestPost(self::TAG_DEL_USER_API, $data);

    }

    public function lists($data = array())
    {
        return $this->mRequestGet(self::TAG_LIST_API, $data);
    }

    public function get($data = array())
    {
        return $this->mRequestGet(self::TAG_GET_USER_API, $data);
    }


    public function user($userid_array)
    {
        if (is_array($userid_array)) {
            $this->_data['userlist'] = $userid_array;
        } else {
            $this->_data['userlist'] = array($userid_array);
        }
        return $this;
    }

    public function department($departmentid_array)
    {
        if (is_array($departmentid_array)) {
            $this->_data['partylist'] = $departmentid_array;
        } else {
            $this->_data['partylist'] = array($departmentid_array);
        }
        return $this;
    }

    public function add()
    {
        if (empty($this->_data['partylist']) && empty($this->_data['userlist'])) {
            throw new \Exception("成员ID跟部门ID不能同时为空");
        }
        return $this->mRequestPost(self::TAG_ADD_USER_API);
    }


    public function name($name)
    {
        $this->setData('tagname', $name);
        return $this;
    }

    public function id($id)
    {
        $this->setData('tagid', $id);
        return $this;
    }

    public function cleanData()
    {
        $this->_data = array();
    }


    private function mRequestPost($url, $data = array())
    {
        $this->_data = array_merge($this->_data, $data);
        if (!isset($this->_data['tagname']) && isset($this->_data['name'])) {
            $this->_data['tagname'] = $this->_data['name'];
        }
        if (!isset($this->_data['tagid']) && isset($this->_data['id'])) {
            $this->_data['tagid'] = $this->_data['id'];
        }
        $return_data = $this->requestPost($url);
        $this->cleanData();
        return $return_data;
    }

    private function mRequestGet($url, $data = array())
    {
        $this->_data = array_merge($this->_data, $data);
        if (!isset($this->_data['tagname']) && isset($this->_data['name'])) {
            $this->_data['tagname'] = $this->_data['name'];
        }
        if (!isset($this->_data['tagid']) && isset($this->_data['id'])) {
            $this->_data['tagid'] = $this->_data['id'];
        }
        $return_data = $this->requestGet($url);
        $this->cleanData();
        return $return_data;
    }

}