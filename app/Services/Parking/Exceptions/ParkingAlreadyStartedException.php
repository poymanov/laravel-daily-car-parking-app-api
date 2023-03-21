<?php

namespace App\Services\Parking\Exceptions;

use Exception;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ParkingAlreadyStartedException extends Exception
{
    public function __construct(Uuid $vehicleId, Uuid $zoneId)
    {
        $message = 'Parking already started for vehicle ' . $vehicleId->value() . ' in zone ' . $zoneId->value() . '.';

        parent::__construct($message);
    }
}
