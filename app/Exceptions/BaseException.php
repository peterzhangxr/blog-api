<?php


namespace App\Exceptions;

use Exception;
/**
 * 自定义系统异常
*/
class BaseException extends Exception
{
    protected $data = [];

    public function __construct($message, $code = -1, $data = array())
    {
        $this->code = $code;

        $this->message = $message;

        $this->data = $data;

    }

}
