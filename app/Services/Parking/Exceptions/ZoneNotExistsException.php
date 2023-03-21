<?php

namespace App\Services\Parking\Exceptions;

use Exception;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ZoneNotExistsException extends Exception
{
    public function __construct(Uuid $id)
    {
        $message = 'Zone not exists: ' . $id->value();

        parent::__construct($message);
    }
}
