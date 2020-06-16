<?php

namespace OssIntegrate\Oss;

use OSS\OssClient;
use OSS\Core\OssException;
use OssIntegrate\LogServer;

class AliyunOssServer
{
    /**
     * 阿里云OSS
     * @param $object string oss路径
     * @param $file string 本地文件路径
     * @return array
     * @throws \Exception
     */
    public function upload($object,$file)
    {
        // 阿里云主账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM账号进行API访问或日常运维，请登录 https://ram.console.aliyun.com 创建RAM账号。
        $accessKeyId = env('ACCESS_ID');
        $accessKeySecret = env('ACCESS_KEY');
        // Endpoint以杭州为例，其它Region请按实际情况填写。
        $endpoint = env('ENDPOINT');
        $bucket= env('BUCKET');
//        $object = "<yourObjectName>";
//        $file = "<yourLocalFile>";

//        $options = array(
//            OssClient::OSS_CHECK_MD5 => true,//开启文件md5检查
//            OssClient::OSS_PART_SIZE => 1,//分片大小
//        );
        try{
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
            $ossClient->multiuploadFile($bucket, $object, $file);
            return ['status' => 'success'];
        } catch(OssException $e) {
            return ['status' => 'error','msg' => $e->getMessage()];
        }
    }
}
