<?php
/**
 * Created by PhpStorm.
 * User: Wailovet
 * Date: 2016/1/5
 * Time: 14:15
 */

namespace Wailovet\wechat;


use Wailovet\Utils\Exception;

class Media extends BaseWechat
{

    const CORP_UPLOAD_TMP_API = 'https://qyapi.weixin.qq.com/cgi-bin/media/upload';
    const CORP_UPLOAD_FOREVER_API = 'https://qyapi.weixin.qq.com/cgi-bin/material/add_material';
    const CORP_GET_RES_API = 'https://qyapi.weixin.qq.com/cgi-bin/media/get';
    const CORP_GET_RES_FOREVER_API = 'https://qyapi.weixin.qq.com/cgi-bin/material/get';
    const CORP_DELETE_RES_API = 'https://qyapi.weixin.qq.com/cgi-bin/material/del';
    const CORP_COUNT_RES_API = 'https://qyapi.weixin.qq.com/cgi-bin/material/get_count';
    const CORP_LIST_RES_API = 'https://qyapi.weixin.qq.com/cgi-bin/material/batchget';

    const TYPE_IMAGE = "image";
    const TYPE_VOICE = "voice";
    const TYPE_VIDEO = "video";
    const TYPE_FILE = "file";


    private $media_file;
    private $is_forever = false;
    private $agentid = -1;

    private $type = "file";
    private $download_dir = "./";

    public function downloadDir($download_dir)
    {
        $this->download_dir = $download_dir;
        return $download_dir;
    }

    public function download($filename = '', $media_id = '')
    {
        return $this->get($filename, $media_id);
    }

    public function get($filename = '', $media_id = '')
    {

        if ($this->is_forever) {
            $url = self::CORP_GET_RES_API;
            if ($this->agentid == -1) {
                throw new \Exception("需要设置agentid");
            }
            $this->_data['agentid'] = $this->agentid;
        } else {
            $url = self::CORP_GET_RES_API;
        }

        if (empty($media_id)) {
            $media_id = $this->_data['media_id'];
            if (empty($media_id)) {
                throw new \Exception("media_id为空");
            }
        }
        return array("url" => $this->requestDownload($url, $this->download_dir, $filename));
    }


    public function upload()
    {
        if ($this->is_forever) {
            $url = self::CORP_UPLOAD_FOREVER_API;
            if ($this->agentid == -1) {
                throw new \Exception("需要设置agentid");
            }

            $op['agentid'] = $this->agentid;
        } else {
            $url = self::CORP_UPLOAD_TMP_API;
        }
        if (empty($this->type)) {
            throw new \Exception("没有选择类型");
        }

        $op['type'] = $this->type;
        $data = $this->requestUpload($url, $op, $this->media_file);
        return $data;
    }


    /**
     * 删除素材
     * @return mixed
     */
    public function delete($data = array())
    {
        if (isset($data['agentid'])) {
            $this->setData("agentid", $data['agentid']);
        } else {
            $this->setData("agentid", $this->agentid);
        }
        if (isset($data['media_id'])) {
            $this->setData("media_id", $data['media_id']);
        }
        return $this->mRequestGet(self::CORP_DELETE_RES_API);
    }


    public function count($agentid = -1)
    {
        if ($agentid != -1) {
            $this->setData("agentid", $agentid);
        }
        return $this->mRequestGet(self::CORP_COUNT_RES_API);
    }


    public function lists($page = 1)
    {
        $count = 50;
        $offset = ($page - 1) * $count;
        $this->setData("count", $count);
        $this->setData("offset", $offset);
        $this->setData("type", $this->type);
        $this->setData("agentid", $this->agentid);
        return $this->mRequestPost(self::CORP_LIST_RES_API);
    }


    public function id($id)
    {
        return $this->mediaId($id);
    }

    public function mediaId($id)
    {
        $this->setData("media_id", $id);
        return $this;
    }

    public function agentId($id)
    {
        $this->agentid = $id;
        return $this;
    }

    public function forever($is_forever = true)
    {
        $this->is_forever = $is_forever;
        return $this;
    }

    public function type($type)
    {
        $this->type = $type;
        return $this;
    }

    public function file($file_path)
    {
        $this->media_file = $file_path;
        return $this;
    }


}