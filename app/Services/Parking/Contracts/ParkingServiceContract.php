<?php

namespace App\Services\Parking\Contracts;

use App\Services\Parking\Dtos\ParkingStartDto;
use App\Services\Parking\Exceptions\CreateParkingFailedException;
use App\Services\Parking\Exceptions\ParkingAlreadyStartedException;
use App\Services\Parking\Exceptions\VehicleNotBelongsToUserException;
use App\Services\Parking\Exceptions\ZoneNotExistsException;

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
     * @throws CreateParkingFailedException
     */
    public function start(int $userId, ParkingStartDto $parkingStartDto): void;
}
