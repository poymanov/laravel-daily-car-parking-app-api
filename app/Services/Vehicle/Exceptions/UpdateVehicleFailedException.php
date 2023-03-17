<?php

namespace App\Services\Vehicle\Exceptions;

use Exception;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class UpdateVehicleFailedException extends Exception
{
    public function __construct(Uuid $id)
    {
        $message = 'Failed to update vehicle. ID: ' . $id->value();

        parent::__construct($message);
    }
}
