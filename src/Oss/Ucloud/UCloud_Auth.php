<?php
namespace OssIntegrate\Oss\Ucloud;

class UCloud_Auth
{

    public $PublicKey;
    public $PrivateKey;

    public function __construct($publicKey, $privateKey)
    {
        $this->PublicKey = $publicKey;
        $this->PrivateKey = $privateKey;
    }

    public function Sign($data)
    {
        $sign = base64_encode(hash_hmac('sha1', $data, $this->PrivateKey, true));
        return "UCloud " . $this->PublicKey . ":" . $sign;
    }

    //@results: $token
    public function SignRequest($req, $mimetype = null, $type = Config::HEAD_FIELD_CHECK)
    {
        $url = $req->URL;
        $url = parse_url($url['path']);
        $data = '';
        $data .= strtoupper($req->METHOD) . "\n";
        $data .= (new Http())->UCloud_Header_Get($req->Header, 'Content-MD5') . "\n";
        if ($mimetype)
            $data .=  $mimetype . "\n";
        else
            $data .= (new Http())->UCloud_Header_Get($req->Header, 'Content-Type') . "\n";
        if ($type === Config::HEAD_FIELD_CHECK)
            $data .= (new Http())->UCloud_Header_Get($req->Header, 'Date') . "\n";
        else
            $data .= (new Http())->UCloud_Header_Get($req->Header, 'Expires') . "\n";
        $data .= (new Digest())->CanonicalizedUCloudHeaders($req->Header);
        $data .= (new Digest())->CanonicalizedResource($req->Bucket, $req->Key);
        return $this->Sign($data);
    }
}