<?php

namespace App\Services\Vehicle;

use App\Services\Vehicle\Contracts\VehicleRepositoryContract;
use App\Services\Vehicle\Contracts\VehicleServiceContract;
use App\Services\Vehicle\Dtos\VehicleDto;

class VehicleService implements VehicleServiceContract
{
    public function __construct(private readonly VehicleRepositoryContract $vehicleRepository)
    {
    }

    /**
     * @inheritDoc
     */
    public function create(int $userId, string $plateNumber): VehicleDto
    {
        return $this->vehicleRepository->create($userId, $plateNumber);
    }
}
