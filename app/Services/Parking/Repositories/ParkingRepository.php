<?php

namespace App\Services\Parking\Repositories;

use App\Models\Parking;
use App\Services\Parking\Contracts\ParkingRepositoryContract;
use App\Services\Parking\Dtos\ParkingStartDto;
use App\Services\Parking\Exceptions\CreateParkingFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ParkingRepository implements ParkingRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function isStarted(Uuid $vehicleId, Uuid $zoneId): bool
    {
        return Parking::whereVehicleId($vehicleId->value())->whereZoneId($zoneId->value())->exists();
    }

    /**
     * @inheritDoc
     */
    public function start(int $userId, ParkingStartDto $parkingStartDto): void
    {
        $parking = new Parking();
        $parking->user_id = $userId;
        $parking->vehicle_id = $parkingStartDto->vehicleId->value();
        $parking->zone_id = $parkingStartDto->zoneId->value();
        $parking->start_time = now();

        if (!$parking->save()) {
            throw new CreateParkingFailedException();
        }
    }
}
