<?php

namespace App\Services\Auth\Exceptions;

use Exception;

class CredentionalsIncorrectException extends Exception
{
    public function __construct()
    {
        $message = 'The provided credentials are incorrect.';

        parent::__construct($message);
    }
}
