<?php

namespace App\Services\Parking\Exceptions;

use Exception;

class CreateParkingFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to create parking';

        parent::__construct($message);
    }
}
