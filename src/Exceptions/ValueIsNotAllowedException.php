<?php

namespace Holo\Exceptions;

use Exception;
use Throwable;

class ValueIsNotAllowedException extends Exception
{

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Sets the message of the exception.
     * @param $message
     */
    final public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Sets the code of the exception.
     * @param int $code
     */
    final public function setCode($code = 0)
    {
        $this->code = $code;
    }
}
