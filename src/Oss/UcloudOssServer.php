<?php

namespace OssIntegrate\Oss;
use OssIntegrate\LogServer;
use OssIntegrate\Oss\Ucloud\Proxy;

//源码地址
//https://github.com/ufilesdk-dev/ufile-phpsdk
class UcloudOssServer
{
    /**
     * @param $local_file string 本地文件绝对路径
     * @param $dest_file  string 远程文件绝对路径
     * @param string $bucket 存储的空间名，不填就是默认
     * @return array
     */
    public function mupload($local_file,$dest_file,$bucket = '')
    {
        $start_time = time();
        //存储空间名
        if(empty($bucket)) {
            $bucket = env('UCLOUD_BUCKET');
        }

        $msg = 'local_file:'.$local_file.'---'.'dest_file'.$dest_file.'---bucket'.$bucket;
        //初始化分片上传,获取本地上传的uploadId和分片大小
        $ucloud_proxy = new Proxy();
        list($data, $err) = $ucloud_proxy->UCloud_MInit($bucket, $dest_file);
        if($err) {
            $end_time = time();
            $msg .= "error: " . $err->ErrMsg.'---'."code: " . $err->Code.'---use_time:'.$end_time-$start_time;
            LogServer::ucloudoss($msg);
            return ['status'=>"error",'msg'=>$msg];
        }

        $uploadId = $data['UploadId'];
        $blkSize  = $data['BlkSize'];
        //数据上传
        list($etagList, $err) = $ucloud_proxy->UCloud_MUpload($bucket, $dest_file, $local_file, $uploadId, $blkSize);
        if ($err) {
            $end_time = time();
            $msg .= "error: " . $err->ErrMsg.'---'."code: " . $err->Code.'---use_time:'.$end_time-$start_time;
            LogServer::ucloudoss($msg);
            return ['status'=>"error",'msg'=>$msg];
        }

        //完成上传
        list($data, $err) = $ucloud_proxy->UCloud_MFinish($bucket, $dest_file, $uploadId, $etagList);
        if ($err) {
            $end_time = time();
            $msg .= "error: " . $err->ErrMsg.'---'."code: " . $err->Code.'---use_time:'.$end_time-$start_time;
            LogServer::ucloudoss($msg);
            return ['status'=>"error",'msg'=>$msg];
        }

        $end_time = time();

        $msg .= "UploadId: " . $uploadId . "---"."BlkSize:  " . $blkSize . "---"."Etag:     " . $data['ETag'].'---'."FileSize: " . $data['FileSize'];
        return ['status'=>'success','msg'=>$msg,
            'uploadid'=>$uploadId,
            'blksize'=>$blkSize,
            'etag'=>$data['ETag'],
            'filesize'=>$data['FileSize'],
            'use_time' => $end_time-$start_time,
        ];
    }
}
