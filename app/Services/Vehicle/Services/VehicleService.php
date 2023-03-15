<?php

namespace App\Services\Vehicle\Services;

use App\Services\Vehicle\Contracts\VehicleCacheServiceContract;
use App\Services\Vehicle\Contracts\VehicleRepositoryContract;
use App\Services\Vehicle\Contracts\VehicleServiceContract;
use App\Services\Vehicle\Dtos\VehicleDto;

class VehicleService implements VehicleServiceContract
{
    public function __construct(
        private readonly VehicleRepositoryContract $vehicleRepository,
        private readonly VehicleCacheServiceContract $cacheService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(int $userId, string $plateNumber): VehicleDto
    {
        $createdVehicle = $this->vehicleRepository->create($userId, $plateNumber);

        $this->cacheService->forgetAll($userId);

        return $createdVehicle;
    }

    /**
     * @inheritDoc
     */
    public function findAllByUserId(int $userId): array
    {
        return $this->cacheService->rememberAndGetAll($userId, function () use ($userId) {
            return $this->vehicleRepository->findAllByUserId($userId);
        });
    }
}
