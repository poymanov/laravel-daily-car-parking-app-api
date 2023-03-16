<?php

namespace App\Services\Vehicle\Exceptions;

use Exception;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Symfony\Component\HttpFoundation\Response;

class VehicleNotBelongsToUserException extends Exception
{
    /**
     * @param Uuid $id
     */
    public function __construct(Uuid $id, int $userId)
    {
        $message = 'Vehicle ' . $id->value() . ' not belongs to user ' . $userId;

        parent::__construct($message);
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return Response::HTTP_FORBIDDEN;
    }
}
