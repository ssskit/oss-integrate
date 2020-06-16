<?php

namespace OssIntegrate\Oss;

use Qcloud\Cos\Client;
use Guzzle\Service\Resource\Model;
class QcloudCosServer extends Model
{

    public function upload($srcPath,$savePath)
    {
        $secretId = env('QCLOUDCOS_SECRETID');
        $secretKey = env('QCLOUDCOS_SECRETKEY');
        $region = env('QCLOUDCOS_REGION');
        $cosClient = new Client(
            array(
                'region' => $region,
                'schema' => 'https', //协议头部，默认为http
                'credentials'=> array(
                    'secretId'  => $secretId ,
                    'secretKey' => $secretKey)));

        ### 上传文件流
        try {
            \Log::info('start.upload');
            $bucket = "sdk-1257915562"; //存储桶名称 格式：BucketName-APPID
//            $key = "game_test/own_sdk1.apk";
//            $srcPath = "E:/xincode/sdk/own_sdk.apk";//本地文件绝对路径
            $key = $savePath;
            $result = $cosClient->putObject(array(
                'Bucket' => $bucket,
                'Key' => $key,
                'Body' => fopen($srcPath, 'rb')));
            $url = parse_url($result->data['ObjectURL']);
            $url = $url['scheme'].'://'.$url['host'].$url['path'];
            //https://blog.csdn.net/jerryyang_2017/article/details/80326872
//            print_r(object_to_array($result));
            return ['status'=>'ok','url'=>$url];
        } catch (\Exception $e) {
            \Log::info($e->getFile().'-'.$e->getCode().'-'.$e->getLine().'-'.$e->getMessage());
            return ['status'=>'false'];
        }
    }


}