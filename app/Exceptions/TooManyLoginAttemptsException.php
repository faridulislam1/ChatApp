<?php

namespace App\Exceptions;

use Exception;

class TooManyLoginAttemptsException extends Exception
{
    protected $message;

    public function __construct($message = "Too many login attempts! Please try again later.")
    {
        parent::__construct($message);
    }
}
