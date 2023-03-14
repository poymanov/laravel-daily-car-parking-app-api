<?php

namespace App\Services\Vehicle\Exceptions;

use Exception;

class CreateVehicleFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to create vehicle';

        parent::__construct($message);
    }
}
