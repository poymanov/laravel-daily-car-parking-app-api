<?php

namespace App\Services\Vehicle\Exceptions;

use Exception;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class DeleteVehicleFailedException extends Exception
{
    public function __construct(Uuid $id)
    {
        $message = 'Failed to delete vehicle. ID: ' . $id->value();

        parent::__construct($message);
    }
}
