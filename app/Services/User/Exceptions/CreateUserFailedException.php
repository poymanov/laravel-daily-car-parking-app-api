<?php

namespace App\Services\User\Exceptions;

use Exception;

class CreateUserFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to create user';

        parent::__construct($message);
    }
}
