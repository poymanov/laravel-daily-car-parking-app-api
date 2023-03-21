<?php

namespace App\Services\Parking\Exceptions;

use Exception;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ParkingNotBelongsToUserException extends Exception
{
    public function __construct(Uuid $id)
    {
        $message = 'Parking ' . $id->value() . ' not belongs to user.';

        parent::__construct($message);
    }
}
