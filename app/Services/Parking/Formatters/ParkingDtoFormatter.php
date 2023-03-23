<?php

namespace App\Services\Parking\Formatters;

use App\Services\Parking\Contracts\ParkingDtoFormatterContract;
use App\Services\Parking\Dtos\ParkingDto;

class ParkingDtoFormatter implements ParkingDtoFormatterContract
{
    /**
     * @inheritDoc
     */
    public function toArray(ParkingDto $dto): array
    {
        return [
            'id'          => $dto->id->value(),
            'zone'        => [
                'name'           => $dto->zone->name,
                'price_per_hour' => $dto->zone->pricePerHour,
            ],
            'vehicle'     => [
                'plate_number' => $dto->vehicle->plateNumber,
            ],
            'start_time'  => $dto->startTime->toDateTimeString(),
            'stop_time'   => $dto->stopTime?->toDateTimeString(),
            'total_price' => $dto->totalPrice,
        ];
    }
}
