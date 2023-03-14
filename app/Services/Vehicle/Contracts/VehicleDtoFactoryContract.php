<?php

namespace App\Services\Vehicle\Contracts;

use App\Models\Vehicle;
use App\Services\Vehicle\Dtos\VehicleDto;

interface VehicleDtoFactoryContract
{
    /**
     * @param Vehicle $vehicle
     *
     * @return VehicleDto
     */
    public function createFromModel(Vehicle $vehicle): VehicleDto;
}
