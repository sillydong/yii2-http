<?php

namespace sillydong\http;

final class Response {
    protected $statusCode;
    protected $headers;
    protected $body;
    protected $error;
    protected $duration;

    /** @var array Mapping of status codes to reason phrases */
    private static $statusTexts = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        226 => 'IM Used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Reserved for WebDAV advanced collections expired proposal',
        426 => 'Upgrade required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates (Experimental)',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    );

    public function __construct($code, $duration, array $headers = array(), $body = null, $error = null) {
        $this->statusCode = $code;
        $this->duration = $duration;
        $this->headers = $headers;
        $this->body = $body;
        $this->error = $error;
        if ($error !== null)
        {
            return;
        }

        if ($body === null)
        {
            if ($code >= 400)
            {
                $this->error = self::$statusTexts[$code];
            }
        }
        else
        {
            if ($code >= 400)
            {
                $this->error = $body;
            }
        }

        return;
    }

    public function ok() {
        return $this->statusCode >= 200 && $this->statusCode < 300 && $this->error === null;
    }
    
    public function get_code(){
        return $this->statusCode;
    }
    
    public function get_header(){
        return $this->headers;
    }

    public function get_body() {
        return $this->body;
    }
    
    public function get_error(){
        return $this->error;
    }

    public function needRetry() {
        $code = $this->statusCode;
        if ($code < 0 || ($code / 100 === 5 and $code !== 579) || $code === 996)
        {
            return true;
        }
    }

    public function isJson() {
        return array_key_exists('Content-Type', $this->headers) && strpos($this->headers['Content-Type'], 'application/json') === 0;
    }

    public function isXml() {
        return array_key_exists('Content-Type', $this->headers) && strpos($this->headers['Content-Type'], 'application/xml') === 0;
    }
}
