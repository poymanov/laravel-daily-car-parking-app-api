<?php

namespace App\Services\Parking\Exceptions;

use Exception;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class StopParkingFailedException extends Exception
{
    public function __construct(Uuid $id)
    {
        $message = 'Failed to stop parking: ' . $id->value();

        parent::__construct($message);
    }
}
