<?php

namespace Novinhub;

use Exception;

class ServerException extends Exception
{
    private $response;
    
    private $trace_id;
    
    public function __construct($message, $trace_id, $respone, Exception $previous = null)
    {
        parent::__construct($message, 0, $previous);
        $this->response = $respone;
        $this->trace_id = $trace_id;
    }
    
    public function getResponse()
    {
        return $this->response;
    }
    
    public function getTraceId()
    {
        return $this->trace_id;
    }
}
