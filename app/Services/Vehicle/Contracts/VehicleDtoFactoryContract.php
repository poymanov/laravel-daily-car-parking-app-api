<?php

namespace App\Services\Vehicle\Contracts;

use App\Models\Vehicle;
use App\Services\Vehicle\Dtos\VehicleDto;
use Illuminate\Database\Eloquent\Collection;

interface VehicleDtoFactoryContract
{
    /**
     * @param Vehicle $vehicle
     *
     * @return VehicleDto
     */
    public function createFromModel(Vehicle $vehicle): VehicleDto;

    /**
     * @param Collection $models
     *
     * @return VehicleDto[]
     */
    public function createFromModels(Collection $models): array;
}
