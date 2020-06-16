<?php
namespace OssIntegrate\Oss\Ucloud;

class HTTP_Response
{
    public $StatusCode;
    public $Header;
    public $ContentLength;
    public $Body;
    public $Timeout;

    public function __construct($code, $body)
    {
        $this->StatusCode = $code;
        $this->Header = array();
        $this->Body = $body;
        $this->ContentLength = strlen($body);

        $CURL_TIMEOUT = 10;
        if ($CURL_TIMEOUT == null) {
            $CURL_TIMEOUT = 10;
        }
        $this->Timeout = $CURL_TIMEOUT;
    }
}