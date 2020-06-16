<?php

namespace OssIntegrate;

/**
 * 日志服务,重要的日志打点记录
 * Class MsgServer
 * @package App\Services
 */
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
class LogServer
{
    /**
     * IOS订单打印函数
     * @param $msg
     * @param $content
     */
    public static  function ios($msg,$content)
    {
        $c = new Logger('ios');
        $path = '/logs/ios/lumen';
        $hander = new StreamHandler(storage_path($path) .date('Y-m-d').'.log');
        $hander->setFormatter(new LineFormatter(null, null, true, true));
        $c->pushHandler($hander);
        $c->info($msg,$content);
    }

    /**
     * 积分墙日志打印函数
     * @param string $msg
     * @param array $content
     */
    public static function wall($msg = '',$content = [])
    {
        $c = new Logger('wall');
        $path = '/logs/wall/lumen';
        $hander = new StreamHandler(storage_path($path) .date('Y-m-d').'.log');
        $hander->setFormatter(new LineFormatter(null, null, true, true));
        $c->pushHandler($hander);
        $c->info($msg,$content);
    }

    /**
     * 广告标识打印日志
     * @param string $msg
     * @param array $content
     */
    public static function atype($msg = '',$content = [])
    {
        $c = new Logger('atype');
        $path = '/logs/atype/lumen';
        $hander = new StreamHandler(storage_path($path) .date('Y-m-d').'.log');
        $hander->setFormatter(new LineFormatter(null, null, true, true));
        $c->pushHandler($hander);
        $c->info($msg,$content);
    }

    /**
     * ucloudoss标识打印日志
     * @param string $msg
     * @param array $content
     */
    public static function ucloudoss($msg = '',$content = [])
    {
        $c = new Logger('atype');
        $path = '/logs/ucloudoss/lumen';
        $hander = new StreamHandler(storage_path($path) .date('Y-m-d').'.log');
        $hander->setFormatter(new LineFormatter(null, null, true, true));
        $c->pushHandler($hander);
        $c->info($msg,$content);
    }

    /**
     * 通用打印日志
     * @param string $name
     * @param string $path
     * @param string $msg
     * @param array $content
     * @throws \Exception
     */
    public static function commonSaveLog($name = '',$path = '',$msg = '',$content = []){
        $c = new Logger($name);
//        $path = '/logs/analyze/queue';
        $hander = new StreamHandler(storage_path($path) .date('Y-m-d').'.log');
        $hander->setFormatter(new LineFormatter(null, null, true, true));
        $c->pushHandler($hander);
        $c->info($msg,$content);
    }


}