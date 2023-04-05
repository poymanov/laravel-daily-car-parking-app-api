<?php

namespace App\Services\Parking\Factories;

use App\Models\Parking;
use App\Services\Parking\Contracts\ParkingDtoFactoryContract;
use App\Services\Parking\Dtos\ParkingDto;
use App\Services\Vehicle\Contracts\VehicleDtoFactoryContract;
use App\Services\Zone\Contracts\ZoneDtoFactoryContract;
use Illuminate\Support\Collection;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ParkingDtoFactory implements ParkingDtoFactoryContract
{
    public function __construct(
        private readonly ZoneDtoFactoryContract $zoneDtoFactory,
        private readonly VehicleDtoFactoryContract $vehicleDtoFactory
    ) {
    }

    /**
     * @inheritDoc
     */
    public function createFromModel(Parking $parking): ParkingDto
    {
        $parkingDto             = new ParkingDto();
        $parkingDto->id         = Uuid::make($parking->id);
        $parkingDto->zone       = $this->zoneDtoFactory->createFromModel($parking->zone);
        $parkingDto->vehicle    = $this->vehicleDtoFactory->createFromModel($parking->vehicle);
        $parkingDto->startTime  = $parking->start_time;
        $parkingDto->stopTime   = $parking->stop_time;
        $parkingDto->userId     = $parking->user_id;
        $parkingDto->totalPrice = $parking->total_price;

        return $parkingDto;
    }

    /**
     * @inheritDoc
     */
    public function createFromModels(Collection $models): array
    {
        $dtos = [];

        foreach ($models as $model) {
            $dtos[] = $this->createFromModel($model);
        }

        return $dtos;
    }
}
