<?php

namespace App\Services\Parking\Contracts;

use App\Services\Parking\Dtos\ParkingStartDto;
use App\Services\Parking\Exceptions\CreateParkingFailedException;
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
     * @throws CreateParkingFailedException
     */
    public function start(int $userId, ParkingStartDto $parkingStartDto): void;
}
