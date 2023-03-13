<?php

namespace App\Services\User\Exceptions;

use Exception;

class UpdateUserPasswordFailedException extends Exception
{
    public function __construct(int $id)
    {
        $message = 'Failed to update user password. Id: ' . $id;

        parent::__construct($message);
    }
}
