<?php

namespace App\Services\Parking\Factories;

use App\Models\Parking;
use App\Services\Parking\Contracts\ParkingDtoFactoryContract;
use App\Services\Parking\Dtos\ParkingDto;
use App\Services\Vehicle\Contracts\VehicleDtoFactoryContract;
use App\Services\Zone\Contracts\ZoneDtoFactoryContract;
use InvalidArgumentException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ParkingDtoFactory implements ParkingDtoFactoryContract
{
    public function __construct(
        private readonly ZoneDtoFactoryContract $zoneDtoFactory,
        private readonly VehicleDtoFactoryContract $vehicleDtoFactory
    ) {
    }

    /**
     * @param Parking $parking
     *
     * @return ParkingDto
     */
    public function createFromModel(Parking $parking): ParkingDto
    {
        $zone = $parking->zone;

        $vehicle = $parking->vehicle;

        if (is_null($zone)) {
            throw new InvalidArgumentException('Failed to get zone for parking: ' . $parking->id);
        }

        if (is_null($vehicle)) {
            throw new InvalidArgumentException('Failed to get vehicle for parking: ' . $parking->id);
        }

        $parkingDto             = new ParkingDto();
        $parkingDto->id         = Uuid::make($parking->id);
        $parkingDto->zone       = $this->zoneDtoFactory->createFromModel($zone);
        $parkingDto->vehicle    = $this->vehicleDtoFactory->createFromModel($vehicle);
        $parkingDto->startTime  = $parking->start_time;
        $parkingDto->stopTime   = $parking->stop_time;
        $parkingDto->totalPrice = $parking->total_price;

        return $parkingDto;
    }
}