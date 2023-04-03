<?php

namespace App\Services\Vehicle\Factories;

use App\Services\Vehicle\Contracts\VehicleCreateDtoFactoryContract;
use App\Services\Vehicle\Dtos\VehicleCreateDto;

class VehicleCreateDtoFactory implements VehicleCreateDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromParam(string $plateNumber, string $description): VehicleCreateDto
    {
        $vehicleCreateDto              = new VehicleCreateDto();
        $vehicleCreateDto->plateNumber = $plateNumber;
        $vehicleCreateDto->description = $description;

        return $vehicleCreateDto;
    }
}
