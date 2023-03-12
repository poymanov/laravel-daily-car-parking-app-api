<?php

namespace App\Services\User\Exceptions;

use Exception;

class UpdateUserFailedException extends Exception
{
    public function __construct(int $id)
    {
        $message = 'Failed to update user. Id: ' . $id;

        parent::__construct($message);
    }
}
