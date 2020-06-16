<?php
namespace OssIntegrate\Oss\Ucloud;

class UCloud_HttpClient
{
    //@results: ($resp, $error)
    public function RoundTrip($req)
    {
        return (new Http())->UCloud_Client_Do($req);
    }
}