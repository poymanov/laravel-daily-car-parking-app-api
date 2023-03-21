<?php

namespace App\Services\Parking\Exceptions;

use Exception;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ParkingAlreadyStoppedException extends Exception
{
    public function __construct(Uuid $id)
    {
        $message = 'Parking ' . $id . ' already stopped.';

        parent::__construct($message);
    }
}
