<?php

namespace App\Exceptions;

use Exception as BaseException;
use Throwable;

class Exception extends BaseException
{
    /**
     * @var int
     */
    protected $code = 500;

    /**
     * @param int $code
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $code = $code ?: $this->code;

        parent::__construct($message, $code, $previous);
    }
}
