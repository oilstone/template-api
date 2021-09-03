<?php

namespace App\Exceptions;

/**
 * Class UnauthorisedActionException
 * @package App\Exceptions
 */
class UnauthorisedActionException extends Exception
{
    /**
     * @var int
     */
    protected $code = 403;
}
