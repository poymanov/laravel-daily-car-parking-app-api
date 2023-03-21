<?php

namespace App\Services\Parking\Contracts;

use App\Services\Parking\Dtos\ParkingStartDto;
use App\Services\Parking\Exceptions\ParkingAlreadyStoppedException;
use App\Services\Parking\Exceptions\ParkingNotBelongsToUserException;
use App\Services\Parking\Exceptions\ParkingNotFoundByIdException;
use App\Services\Parking\Exceptions\StartParkingFailedException;
use App\Services\Parking\Exceptions\ParkingAlreadyStartedException;
use App\Services\Parking\Exceptions\StopParkingFailedException;
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
     * @param int  $userId
     *
     * @return void
     * @throws ParkingAlreadyStoppedException
     * @throws ParkingNotBelongsToUserException
     * @throws ParkingNotFoundByIdException
     * @throws StopParkingFailedException
     */
    public function stop(Uuid $id, int $userId): void;
}
