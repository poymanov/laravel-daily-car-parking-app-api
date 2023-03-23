<?php

namespace App\Services\Parking\Services;

use App\Services\Parking\Contracts\ParkingRepositoryContract;
use App\Services\Parking\Contracts\ParkingServiceContract;
use App\Services\Parking\Contracts\ParkingUserServiceContract;
use App\Services\Parking\Dtos\ParkingDto;
use App\Services\Parking\Exceptions\ParkingNotBelongsToUserException;
use App\Services\Parking\Exceptions\ParkingNotFoundByIdException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ParkingUserService implements ParkingUserServiceContract
{
    public function __construct(
        private readonly ParkingServiceContract $parkingService,
        private readonly ParkingRepositoryContract $parkingRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getOneById(Uuid $id, int $userId): ParkingDto
    {
        $parking = $this->parkingService->getOneById($id);

        // Если парковка не принадлежит пользователю
        if (!$this->parkingRepository->isBelongsToUser($id, $userId)) {
            throw new ParkingNotBelongsToUserException($id);
        }

        return $parking;
    }

    /**
     * @param Uuid $id
     * @param int  $userId
     *
     * @return void
     * @throws ParkingNotBelongsToUserException
     * @throws ParkingNotFoundByIdException
     * @throws \App\Services\Parking\Exceptions\ParkingAlreadyStoppedException
     * @throws \App\Services\Parking\Exceptions\StopParkingFailedException
     */
    public function stop(Uuid $id, int $userId): void
    {
        // Если парковка не найдена
        if (!$this->parkingRepository->isExistsById($id)) {
            throw new ParkingNotFoundByIdException($id);
        }

        // Если парковка не принадлежит пользователю
        if (!$this->parkingRepository->isBelongsToUser($id, $userId)) {
            throw new ParkingNotBelongsToUserException($id);
        }

        $this->parkingService->stop($id);
    }
}
