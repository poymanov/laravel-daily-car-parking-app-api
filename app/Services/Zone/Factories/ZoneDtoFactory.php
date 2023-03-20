<?php

namespace App\Services\Zone\Factories;

use App\Models\Zone;
use App\Services\Zone\Contracts\ZoneDtoFactoryContract;
use App\Services\Zone\Dtos\ZoneDto;
use Illuminate\Database\Eloquent\Collection;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ZoneDtoFactory implements ZoneDtoFactoryContract
{
    /**
     * @param Zone $zone
     *
     * @return ZoneDto
     */
    public function createFromModel(Zone $zone): ZoneDto
    {
        $zoneDto               = new ZoneDto();
        $zoneDto->id           = Uuid::make($zone->id);
        $zoneDto->name         = $zone->name;
        $zoneDto->pricePerHour = $zone->price_per_hour;

        return $zoneDto;
    }

    /**
     * @param Collection $models
     *
     * @return ZoneDto[]
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
