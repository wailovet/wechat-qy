<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/21
 * Time: 16:49
 */

namespace Wailovet\Utils;


class Error
{
    public static function check($data){
        if(isset($data['errcode'])&&!empty($data['errcode']) ){
            throw new \Exception($data['errmsg']);
        }
        return $data;
    }
}