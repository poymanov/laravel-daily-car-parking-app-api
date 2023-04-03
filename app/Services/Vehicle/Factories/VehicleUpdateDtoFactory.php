<?php

namespace App\Services\Vehicle\Factories;

use App\Services\Vehicle\Contracts\VehicleUpdateDtoFactoryContract;
use App\Services\Vehicle\Dtos\VehicleUpdateDto;

class VehicleUpdateDtoFactory implements VehicleUpdateDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromParam(string $plateNumber, ?string $description): VehicleUpdateDto
    {
        $vehicleUpdateDto = new VehicleUpdateDto();
        $vehicleUpdateDto->plateNumber = $plateNumber;
        $vehicleUpdateDto->description = $description;

        return $vehicleUpdateDto;
    }
}
