<?php

namespace App\Services\Vehicle\Services;

use App\Services\Vehicle\Contracts\VehicleServiceContract;
use App\Services\Vehicle\Contracts\VehicleUserServiceContract;
use App\Services\Vehicle\Dtos\VehicleDto;
use App\Services\Vehicle\Dtos\VehicleUpdateDto;
use App\Services\Vehicle\Exceptions\VehicleNotBelongsToUserException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class VehicleUserService implements VehicleUserServiceContract
{
    public function __construct(
        private readonly VehicleServiceContract $vehicleService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function update(Uuid $id, int $userId, VehicleUpdateDto $vehicleUpdateDto): void
    {
        $vehicle = $this->vehicleService->getOneById($id);

        $this->checkBelongsToUser($vehicle, $userId);

        $this->vehicleService->update($id, $vehicleUpdateDto);
    }

    /**
     * @inheritDoc
     */
    public function delete(Uuid $id, int $userId): void
    {
        $vehicle = $this->vehicleService->getOneById($id);

        $this->checkBelongsToUser($vehicle, $userId);

        $this->vehicleService->delete($id);
    }

    /**
     * @inheritDoc
     */
    public function getOneById(Uuid $id, int $userId): VehicleDto
    {
        $vehicle = $this->vehicleService->getOneById($id);

        $this->checkBelongsToUser($vehicle, $userId);

        return $vehicle;
    }

    /**
     * Проверка, принадлежит ли транспортное средство пользователю
     *
     * @param VehicleDto $vehicle
     * @param int        $userId
     *
     * @return void
     * @throws VehicleNotBelongsToUserException
     */
    private function checkBelongsToUser(VehicleDto $vehicle, int $userId): void
    {
        // Если транспортное средство не принадлежит пользователю
        if ($vehicle->userId !== $userId) {
            throw new VehicleNotBelongsToUserException($vehicle->id, $userId);
        }
    }
}
