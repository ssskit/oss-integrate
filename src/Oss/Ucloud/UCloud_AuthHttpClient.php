<?php
namespace OssIntegrate\Oss\Ucloud;

class UCloud_AuthHttpClient
{
    public $Auth;
    public $Type;
    public $MimeType;

    public function __construct($auth, $mimetype = null, $type = Config::HEAD_FIELD_CHECK)
    {
        $this->Type = $type;
        $this->MimeType = $mimetype;
        $this->Auth = (new Digest())->UCloud_MakeAuth($auth, $type);
    }

    //@results: ($resp, $error)
    public function RoundTrip($req)
    {
        if ($this->Type === Config::HEAD_FIELD_CHECK) {
            $token = $this->Auth->SignRequest($req, $this->MimeType, $this->Type);
            $req->Header['Authorization'] = $token;
        }
        return (new Http())->UCloud_Client_Do($req);
    }
}