<?php

namespace App\Services\Parking\Exceptions;

use Exception;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ParkingUpdateTotalPriceFailedException extends Exception
{
    public function __construct(Uuid $id)
    {
        $message = 'Failed to update total price for parking: ' . $id->value();

        parent::__construct($message);
    }
}
