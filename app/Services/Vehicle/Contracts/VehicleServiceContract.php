<?php

namespace App\Services\Vehicle\Contracts;

use App\Services\Vehicle\Dtos\VehicleDto;
use App\Services\Vehicle\Exceptions\CreateVehicleFailedException;

interface VehicleServiceContract
{
    /**
     * @param int    $userId
     * @param string $plateNumber
     *
     * @return VehicleDto
     * @throws CreateVehicleFailedException
     */
    public function create(int $userId, string $plateNumber): VehicleDto;
}
