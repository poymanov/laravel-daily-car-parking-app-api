<?php

namespace App\Services\Parking\Exceptions;

use Exception;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class VehicleNotBelongsToUserException extends Exception
{
    public function __construct(Uuid $vehicleId)
    {
        $message = 'Vehicle ' . $vehicleId->value() . ' not belongs to user.';

        parent::__construct($message);
    }
}
