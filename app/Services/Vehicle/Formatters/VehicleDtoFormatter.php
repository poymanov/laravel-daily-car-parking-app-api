<?php

namespace App\Services\Vehicle\Formatters;

use App\Services\Vehicle\Contracts\VehicleDtoFormatterContract;
use App\Services\Vehicle\Dtos\VehicleDto;

class VehicleDtoFormatter implements VehicleDtoFormatterContract
{
    /**
     * @inheritDoc
     */
    public function toArray(VehicleDto $dto): array
    {
        return [
            'id'           => $dto->id->value(),
            'user_id'      => $dto->userId,
            'plate_number' => $dto->plateNumber,
        ];
    }
}
