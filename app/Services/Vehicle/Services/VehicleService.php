<?php

namespace App\Services\Vehicle\Services;

use App\Services\Vehicle\Contracts\VehicleCacheServiceContract;
use App\Services\Vehicle\Contracts\VehicleRepositoryContract;
use App\Services\Vehicle\Contracts\VehicleServiceContract;
use App\Services\Vehicle\Dtos\VehicleCreateDto;
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
    public function create(int $userId, VehicleCreateDto $vehicleCreateDto): Uuid
    {
        $createdVehicleId = $this->vehicleRepository->create($userId, $vehicleCreateDto);

        $this->cacheService->forgetAll();

        return $createdVehicleId;
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
     * @param Uuid $id
     *
     * @return VehicleDto
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

    /**
     * @inheritDoc
     */
    public function isBelongsToUser(Uuid $id, int $userId): bool
    {
        return $this->vehicleRepository->isBelongsToUser($id, $userId);
    }
}
