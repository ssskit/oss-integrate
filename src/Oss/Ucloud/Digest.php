<?php
namespace OssIntegrate\Oss\Ucloud;

class Digest
{
    // ----------------------------------------------------------
    function CanonicalizedResource($bucket, $key)
    {
        return "/" . $bucket . "/" . $key;
    }

    function CanonicalizedUCloudHeaders($headers)
    {

        $keys = array();
        foreach($headers as $header) {
            $header = trim($header);
            $arr = explode(':', $header);
            if (count($arr) < 2) continue;
            list($k, $v) = $arr;
            $k = strtolower($k);
            if (strncasecmp($k, "x-ucloud") === 0) {
                $keys[] = $k;
            }
        }

        $c = '';
        sort($keys, SORT_STRING);
        foreach($keys as $k) {
            $c .= $k . ":" . trim($headers[$v], " ") . "\n";
        }
        return $c;
    }



    function UCloud_MakeAuth($auth)
    {
        if (isset($auth)) {
            return $auth;
        }


        $UCLOUD_PUBLIC_KEY = env('UCLOUD_PUBLIC_KEY');
        $UCLOUD_PRIVATE_KEY = env('UCLOUD_PRIVATE_KEY');

        return new UCloud_Auth($UCLOUD_PUBLIC_KEY, $UCLOUD_PRIVATE_KEY);
    }

//@results: token
    function UCloud_SignRequest($auth, $req, $type = Config::HEAD_FIELD_CHECK)
    {
        return (new Digest())->UCloud_MakeAuth($auth)->SignRequest($req, $type);
    }

// ----------------------------------------------------------
}








