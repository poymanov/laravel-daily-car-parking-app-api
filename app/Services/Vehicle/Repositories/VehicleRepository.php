<?php

namespace App\Services\Vehicle\Repositories;

use App\Models\Vehicle;
use App\Services\Vehicle\Contracts\VehicleDtoFactoryContract;
use App\Services\Vehicle\Contracts\VehicleRepositoryContract;
use App\Services\Vehicle\Dtos\VehicleDto;
use App\Services\Vehicle\Exceptions\CreateVehicleFailedException;

class VehicleRepository implements VehicleRepositoryContract
{
    public function __construct(private readonly VehicleDtoFactoryContract $vehicleDtoFactory)
    {
    }

    /**
     * @inheritDoc
     */
    public function create(int $userId, string $plateNumber): VehicleDto
    {
        $vehicle               = new Vehicle();
        $vehicle->user_id      = $userId;
        $vehicle->plate_number = $plateNumber;

        if (!$vehicle->save()) {
            throw new CreateVehicleFailedException();
        }

        return $this->vehicleDtoFactory->createFromModel($vehicle);
    }

    /**
     * @inheritDoc
     */
    public function findAllByUserId(int $userId): array
    {
        $vehicles = Vehicle::whereUserId($userId)->latest()->get();

        return $this->vehicleDtoFactory->createFromModels($vehicles);
    }
}
