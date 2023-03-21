<?php

namespace App\Services\Parking\Contracts;

use App\Services\Parking\Dtos\ParkingStartDto;
use App\Services\Parking\Exceptions\ParkingNotFoundByIdException;
use App\Services\Parking\Exceptions\StartParkingFailedException;
use App\Services\Parking\Exceptions\StopParkingFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ParkingRepositoryContract
{
    /**
     * @param Uuid $vehicleId
     * @param Uuid $zoneId
     *
     * @return bool
     */
    public function isStarted(Uuid $vehicleId, Uuid $zoneId): bool;

    /**
     * @param int             $userId
     * @param ParkingStartDto $parkingStartDto
     *
     * @return void
     * @throws StartParkingFailedException
     */
    public function start(int $userId, ParkingStartDto $parkingStartDto): void;

    /**
     * @param Uuid $id
     *
     * @return bool
     */
    public function isExistsById(Uuid $id): bool;

    /**
     * @param Uuid $id
     * @param int  $userId
     *
     * @return bool
     */
    public function isBelongsToUser(Uuid $id, int $userId): bool;

    /**
     * @param Uuid $id
     *
     * @return bool
     */
    public function isStopped(Uuid $id): bool;

    /**
     * @param Uuid $id
     *
     * @return void
     * @throws ParkingNotFoundByIdException
     * @throws StopParkingFailedException
     */
    public function stop(Uuid $id): void;
}
