<?php
/**
 * Created by PhpStorm.
 * User: Wailovet
 * Date: 2015/12/23
 * Time: 10:17
 */

namespace Wailovet\wechat\AddressBook;

use Wailovet\wechat\BaseWechat;

class User extends BaseWechat
{

    const USER_CREATE_API = 'https://qyapi.weixin.qq.com/cgi-bin/user/create';
    const USER_UPDATE_API = 'https://qyapi.weixin.qq.com/cgi-bin/user/update';
    const USER_DELETE_API = 'https://qyapi.weixin.qq.com/cgi-bin/user/delete';
    const USER_BATCHDELETE_API = 'https://qyapi.weixin.qq.com/cgi-bin/user/batchdelete';
    const USER_GET_API = 'https://qyapi.weixin.qq.com/cgi-bin/user/get';
    const USER_SIMPLELIST_API = 'https://qyapi.weixin.qq.com/cgi-bin/user/simplelist';
    const USER_DETAILEDLIST_API = 'https://qyapi.weixin.qq.com/cgi-bin/user/list';


    const SEX_MALE = 1;
    const SEX_WOMAN = 2;
    private $list_simple = false;

    public function create($data = array())
    {
        if (!isset($this->_data['department']) && !isset($data['department'])) {
            $this->_data['department'] = 1;
        }
        return $this->mRequestPost(self::USER_CREATE_API, $data);
    }

    public function update($data = array())
    {
        return $this->mRequestPost(self::USER_UPDATE_API, $data);
    }

    public function delete($data = array())
    {
        if (isset($this->_data['useridlist'])) {
            return $this->batchDelete($data);
        }
        return $this->mRequestGet(self::USER_DELETE_API, $data);
    }

    public function batchDelete($data = array())
    {
        return $this->mRequestPost(self::USER_BATCHDELETE_API, $data);
    }

    public function get($data = array())
    {
        return $this->mRequestGet(self::USER_GET_API, $data);
    }


    public function lists($data = array())
    {
        if ($this->list_simple) {
            return $this->simpleList($data);
        }
        return $this->detailedList($data);
    }

    public function simpleList($data = array())
    {
        return $this->_list(self::USER_SIMPLELIST_API, $data);
    }

    public function detailedList($data = array())
    {
        return $this->_list(self::USER_DETAILEDLIST_API, $data);
    }

    private function _list($url, $data = array(), $isFetchChild = false)
    {
        $this->fetchChild($isFetchChild);
        return $this->mRequestGet($url, $data);
    }


    protected function cleanData()
    {
        parent::cleanData();
        $this->list_simple = false;
    }


    public function data($data)
    {
        $this->_data = $data;
        return $this;
    }

    public function userid($userid)
    {
        $this->setData('userid', $userid);
        return $this;
    }

    public function name($name)
    {
        $this->setData('name', $name);
        return $this;
    }

    public function department($department)
    {
        $this->setData('department', $department);
        $this->setData('department_id', $department);
        return $this;
    }

    public function departmentId($department)
    {
        $this->setData('department', $department);
        $this->setData('department_id', $department);
        return $this;
    }

    public function position($position)
    {
        $this->setData('position', $position);
        return $this;
    }

    public function mobile($mobile)
    {
        $this->setData('mobile', $mobile);
        return $this;
    }

    public function gender($gender)
    {
        $this->setData('gender', $gender);
        return $this;
    }

    public function sex($sex)
    {
        $this->setData('gender', $sex);
        return $this;
    }

    public function email($email)
    {
        $this->setData('email', $email);
        return $this;
    }

    public function weixinid($weixinid)
    {
        $this->setData('weixinid', $weixinid);
        return $this;
    }

    public function avatarMediaid($avatar_mediaid)
    {
        $this->setData('avatar_mediaid', $avatar_mediaid);
        return $this;
    }

    public function extattr($extattr)
    {
        $this->setData('extattr', $extattr);
        return $this;
    }

    public function fetchChild($fetch_child = true)
    {
        if ($fetch_child) {
            $this->setData('fetch_child', '1');
        } else {
            $this->setData('fetch_child', '0');
        }
        return $this;
    }

    public function status($status)
    {
        if (empty($this->status[intval($status)])) {
            if (empty($this->_data['status'])) {
                $this->_data['status'] = 0;
            }
            $status = intval($this->_data['status']) + intval($status);
            $this->status[intval($status)] = true;
            $this->setData('status', $status);
        }
        return $this;
    }


    public function enable($enable = true)
    {
        if ($enable) {
            $this->setData('enable', '1');
        } else {
            $this->setData('enable', '0');
        }
        return $this;
    }

    public function follow($isFollow = true)
    {
        if ($isFollow) {
            $this->status(1);
        } else {
            $this->status(4);
        }
        return $this;
    }

    public function notFollow()
    {
        $this->status(4);
        return $this;
    }

    public function disabled()
    {
        $this->status(2);
        $this->enable(0);
        return $this;
    }


    public function simple()
    {
        $this->list_simple = true;
        return $this;
    }

    public function useridlist($useridlist)
    {
        $this->setData('useridlist', $useridlist);
        return $this;
    }
}