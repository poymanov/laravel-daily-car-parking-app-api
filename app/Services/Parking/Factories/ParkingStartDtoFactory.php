<?php

namespace App\Services\Parking\Factories;

use App\Services\Parking\Contracts\ParkingStartDtoFactoryContract;
use App\Services\Parking\Dtos\ParkingStartDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ParkingStartDtoFactory implements ParkingStartDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromParams(string $vehicleId, string $zoneId): ParkingStartDto
    {
        $parkingStartDto            = new ParkingStartDto();
        $parkingStartDto->vehicleId = Uuid::make($vehicleId);
        $parkingStartDto->zoneId    = Uuid::make($zoneId);

        return $parkingStartDto;
    }
}
