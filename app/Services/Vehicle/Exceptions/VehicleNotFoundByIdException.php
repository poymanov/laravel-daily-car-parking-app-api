<?php

namespace App\Services\Vehicle\Exceptions;

use Exception;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Symfony\Component\HttpFoundation\Response;

class VehicleNotFoundByIdException extends Exception
{
    /**
     * @param Uuid $id
     */
    public function __construct(Uuid $id)
    {
        $message = 'Vehicle not found by id: ' . $id->value();

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
