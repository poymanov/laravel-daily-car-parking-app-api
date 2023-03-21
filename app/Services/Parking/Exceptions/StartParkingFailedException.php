<?php

namespace App\Services\Parking\Exceptions;

use Exception;

class StartParkingFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to start parking';

        parent::__construct($message);
    }
}
