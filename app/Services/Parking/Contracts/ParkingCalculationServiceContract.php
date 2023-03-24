<?php

namespace App\Services\Parking\Contracts;

use App\Services\Parking\Exceptions\ParkingNotFoundByIdException;
use App\Services\Parking\Exceptions\ParkingUpdateTotalPriceFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ParkingCalculationServiceContract
{
    /**
     * @param Uuid $id
     *
     * @return void
     * @throws ParkingNotFoundByIdException
     * @throws ParkingUpdateTotalPriceFailedException
     */
    public function calculateTotalPrice(Uuid $id): void;
}
