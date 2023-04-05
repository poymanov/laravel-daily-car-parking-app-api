<?php

namespace App\Services\Parking\Contracts;

use App\Services\Parking\Dtos\ParkingDto;
use App\Services\Parking\Dtos\ParkingStartDto;
use App\Services\Parking\Exceptions\ParkingAlreadyStoppedException;
use App\Services\Parking\Exceptions\ParkingNotFoundByIdException;
use App\Services\Parking\Exceptions\StartParkingFailedException;
use App\Services\Parking\Exceptions\ParkingAlreadyStartedException;
use App\Services\Parking\Exceptions\VehicleNotBelongsToUserException;
use App\Services\Parking\Exceptions\ZoneNotExistsException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ParkingServiceContract
{
    /**
     * @param int             $userId
     * @param ParkingStartDto $parkingStartDto
     *
     * @return void
     * @throws ParkingAlreadyStartedException
     * @throws VehicleNotBelongsToUserException
     * @throws ZoneNotExistsException
     * @throws StartParkingFailedException
     */
    public function start(int $userId, ParkingStartDto $parkingStartDto): void;

    /**
     * @param Uuid $id
     *
     * @return void
     * @throws ParkingAlreadyStoppedException
     * @throws ParkingNotFoundByIdException
     * @throws \App\Services\Parking\Exceptions\StopParkingFailedException
     */
    public function stop(Uuid $id): void;

    /**
     * @param Uuid $id
     *
     * @return ParkingDto
     * @throws ParkingNotFoundByIdException
     */
    public function getOneById(Uuid $id): ParkingDto;

    /**
     * @return ParkingDto[]
     */
    public function findAllActive(): array;

    /**
     * @param int $userId
     *
     * @return ParkingDto[]
     */
    public function findAllActiveByUserId(int $userId): array;
}
