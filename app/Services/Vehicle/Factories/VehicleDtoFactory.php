<?php

namespace App\Services\Vehicle\Factories;

use App\Models\Vehicle;
use App\Services\Vehicle\Contracts\VehicleDtoFactoryContract;
use App\Services\Vehicle\Dtos\VehicleDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class VehicleDtoFactory implements VehicleDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromModel(Vehicle $vehicle): VehicleDto
    {
        $vehicleDto              = new VehicleDto();
        $vehicleDto->id          = Uuid::make($vehicle->id);
        $vehicleDto->userId      = $vehicle->user_id;
        $vehicleDto->plateNumber = $vehicle->plate_number;

        return $vehicleDto;
    }
}
