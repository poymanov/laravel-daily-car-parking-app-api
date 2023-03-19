<?php

namespace App\Services\Zone\Factories;

use App\Services\Zone\Contracts\CreateZoneDtoFactoryContract;
use App\Services\Zone\Dtos\CreateZoneDto;

class CreateZoneDtoFactory implements CreateZoneDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromParams(string $name, int $pricePerHour): CreateZoneDto
    {
        $createZoneDto               = new CreateZoneDto();
        $createZoneDto->name         = $name;
        $createZoneDto->pricePerHour = $pricePerHour;

        return $createZoneDto;
    }
}
