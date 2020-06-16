<?php
namespace OssIntegrate\Oss\Ucloud;

class HTTP_Request
{
    public $URL;
    public $RawQuerys;
    public $Header;
    public $Body;
    public $UA;
    public $METHOD;
    public $Params;      //map
    public $Bucket;
    public $Key;
    public $Timeout;

    public function __construct($method, $url, $body, $bucket, $key, $action_type = ActionType::NONE)
    {
        $this->URL    = $url;
        if (isset($url["query"])) {
            $this->RawQuerys = $url["query"];
        }
        $this->Header = array();
        $this->Body   = $body;
        $this->UA     = (new Http())->UCloud_UserAgent();
        $this->METHOD = $method;
        $this->Bucket = $bucket;
        $this->Key    = $key;

        $CURL_TIMEOUT = Config::CURL_TIMEOUT;
        if ($CURL_TIMEOUT == null && $action_type !== ActionType::PUTFILE
            && $action_type !== ActionType::POSTFILE) {
            $CURL_TIMEOUT = 10;
        }
        $this->Timeout = $CURL_TIMEOUT;
    }

    public function EncodedQuery() {
        if ($this->RawQuerys != null) {
            $q = "";
            foreach ($this->RawQuerys as $k => $v) {
                $q = $q . "&" . rawurlencode($k) . "=" . rawurlencode($v);
            }
            return $q;
        }
        return "";
    }
}