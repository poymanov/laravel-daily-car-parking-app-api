<?php

namespace App\Services\Parking\Exceptions;

use Exception;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Symfony\Component\HttpFoundation\Response;

class ParkingNotFoundByIdException extends Exception
{
    /**
     * @param Uuid $id
     */
    public function __construct(Uuid $id)
    {
        $message = 'Parking not found by id: ' . $id->value();

        parent::__construct($message);
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
