<?php

namespace App\Services\Zone\Exceptions;

use Exception;

class CreateZoneFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to create zone';

        parent::__construct($message);
    }
}
