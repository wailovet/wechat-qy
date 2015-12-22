<?php
namespace Wailovet\Utils;

class Request
{
    const FILTER_NONE = 0;
    const FILTER_PHONE = 1;
    const FILTER_NAME = 2;
    const FILTER_NOTEMPTY = 3;
    const FILTER_EMAIL = 4;
    const FILTER_IDCARD = 5;
    const FILTER_URL = 6;
    const FILTER_POSTCODE = 7;
    public static $filter_msg = array(
        Request::FILTER_PHONE => "必须为正确的手机号码",
        Request::FILTER_NOTEMPTY => "不能为空",
        Request::FILTER_EMAIL => "必须为正确的邮箱地址",
        Request::FILTER_IDCARD => "必须为正确的身份证号码",
        Request::FILTER_URL => "必须为正确的URL",
        Request::FILTER_POSTCODE => "必须为正确的邮政编码",
        Request::FILTER_NAME => "必须为正确的姓名");

    public static function data($data_arr, $name, $filter, $is_htmlspecialchars )
    {
        if(!isset($data_arr[$name])){
            return '';
        }
        $data = $data_arr[$name];
        if ($is_htmlspecialchars ) {
            $data = htmlspecialchars($data);
        }
        if (is_array($filter)) {
            foreach ($filter as $key => $val) {
                if (!preg_match($key, $data)) {
                    throw new \Exception($val);
                }
            }
        } else {
            switch ($filter) {
                case Request::FILTER_PHONE:
                    if (!preg_match("/^[(86)|0]?1[3458][0-9]{9}$/", $data)) {
                        throw new \Exception(Request::$filter_msg[$filter]);
                    }
                    break;
                case Request::FILTER_NOTEMPTY:
                    if (empty($data)) {
                        throw new \Exception(Request::$filter_msg[$filter]);
                    }
                    break;
                case Request::FILTER_EMAIL:
                    if (!preg_match("/^[\\w\\d]+[\\w\\d-.]*@[\\w\\d-.]+\\.[\\w\\d]{2,10}$/i", $data)) {
                        throw new \Exception(Request::$filter_msg[$filter]);
                    }
                    break;
                case Request::FILTER_IDCARD:
                    if (!preg_match("/^\\d{6}((1[89])|(2\\d))\\d{2}((0\\d)|(1[0-2]))((3[01])|([0-2]\\d))\\d{3}(\\d|X)$/i", $data)) {
                        throw new \Exception(Request::$filter_msg[$filter]);
                    }
                    break;
                case Request::FILTER_URL:
                    if (!preg_match("/^(http:\\/\\/)?(https:\\/\\/)?([\\w\\d-]+\\.)+[\\w-]+(\\/[\\d\\w-.\\/?%&=]*)?$/", $data)) {
                        throw new \Exception(Request::$filter_msg[$filter]);
                    }
                    break;
                case Request::FILTER_URL:
                    if (!preg_match("/\\d{6}/", $data)) {
                        throw new \Exception(Request::$filter_msg[$filter]);
                    }
                    break;
                case Request::FILTER_NAME:
                    if (!preg_match("/^[_\\w\\d\\x{4e00}-\\x{9fa5}]{6,25}$/iu'", $data)) {
                        throw new \Exception(Request::$filter_msg[$filter]);
                    }
                    break;
            }
        }
        return $data;
    }

    public static function post($name, $filter = Request::FILTER_NONE, $is_htmlspecialchars  = true, $is_mysql_real_escape_string = true)
    {
        return Request::data($_POST, $name, $filter, $is_htmlspecialchars , $is_mysql_real_escape_string);
    }
    public static function get($name, $filter = Request::FILTER_NONE, $is_htmlspecialchars  = true, $is_mysql_real_escape_string = true)
    {
        return Request::data($_GET, $name, $filter, $is_htmlspecialchars , $is_mysql_real_escape_string);
    }
    public static function session($name, $filter = Request::FILTER_NONE, $is_htmlspecialchars  = true, $is_mysql_real_escape_string = true)
    {
        return Request::data($_SESSION, $name, $filter, $is_htmlspecialchars , $is_mysql_real_escape_string);
    }
}