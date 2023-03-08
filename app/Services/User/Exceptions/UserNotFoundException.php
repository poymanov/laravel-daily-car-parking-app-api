<?php

namespace App\Services\User\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    public function __construct(int $id)
    {
        $message = 'User not found: ' . $id;

        parent::__construct($message);
    }
}
