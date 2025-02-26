<?php
namespace App\Domain\Exception;

use Exception;

class UserAlreadyExistsException extends Exception
{
    public function __construct($message = "El email ya está en uso.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}