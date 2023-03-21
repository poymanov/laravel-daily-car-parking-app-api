<?php

namespace App\Services\Parking\Contracts;

use App\Services\Parking\Dtos\ParkingStartDto;

interface ParkingStartDtoFactoryContract
{
    /**
     * @param string $vehicleId
     * @param string $zoneId
     *
     * @return ParkingStartDto
     */
    public function createFromParams(string $vehicleId, string $zoneId): ParkingStartDto;
}
