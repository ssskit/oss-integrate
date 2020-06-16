<?php
namespace OssIntegrate;
use OssIntegrate\Oss\UcloudOssServer;
use OssIntegrate\Oss\QcloudCosServer;
use OssIntegrate\Oss\AliyunOssServer;

class OssHandle{
    /**
     * 选择OSS运营商
     * @param $localPath string 本地文件路径
     * @param $savePath string OSS存储路径
     * @param $osstype string OSS类型
     * @return array|bool
     */
    public static function OssType($localPath, $savePath,$osstype){
//        $osstype = env('OSS_TYPE','ucloud'); // tencent=>腾讯云，aliyun=>阿里云，ucloud=>Ucloud
        $res = [];
        switch ($osstype){
            case('tencent'):
                $res = (new QcloudCosServer())->upload($localPath,$savePath);
                break;
            case('aliyun'):
                $res = (new AliyunOssServer())->upload($savePath,$localPath);
                break;
            case('ucloud'):
                $res = (new UcloudOssServer())->mupload($localPath,$savePath);
                break;
        }
        return $res;
    }
}