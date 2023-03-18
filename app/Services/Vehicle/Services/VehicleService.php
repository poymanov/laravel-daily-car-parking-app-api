<?php

namespace App\Services\Vehicle\Services;

use App\Services\Vehicle\Contracts\VehicleCacheServiceContract;
use App\Services\Vehicle\Contracts\VehicleRepositoryContract;
use App\Services\Vehicle\Contracts\VehicleServiceContract;
use App\Services\Vehicle\Dtos\VehicleDto;
use App\Services\Vehicle\Dtos\VehicleUpdateDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

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

        $this->cacheService->forgetAll();

        return $createdVehicle;
    }

    /**
     * @inheritDoc
     */
    public function update(Uuid $id, VehicleUpdateDto $vehicleUpdateDto): void
    {
        $this->vehicleRepository->update($id, $vehicleUpdateDto);

        $this->cacheService->forgetAll();
    }

    /**
     * @inheritDoc
     */
    public function getOneById(Uuid $id): VehicleDto
    {
        return $this->cacheService->rememberAndGetOneById($id, function () use ($id) {
            return $this->vehicleRepository->getOneById($id);
        });
    }

    /**
     * @inheritDoc
     */
    public function findAllByUserId(int $userId): array
    {
        return $this->cacheService->rememberAndGetAllByUserId($userId, function () use ($userId) {
            return $this->vehicleRepository->findAllByUserId($userId);
        });
    }

    /**
     * @inheritDoc
     */
    public function delete(Uuid $id): void
    {
        $this->vehicleRepository->delete($id);

        $this->cacheService->forgetAll();
    }
}
