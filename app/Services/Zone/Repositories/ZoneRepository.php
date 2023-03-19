<?php

namespace App\Services\Zone\Repositories;

use App\Models\Zone;
use App\Services\Zone\Contracts\ZoneRepositoryContract;
use App\Services\Zone\Dtos\CreateZoneDto;
use App\Services\Zone\Exceptions\CreateZoneFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ZoneRepository implements ZoneRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function create(CreateZoneDto $createZoneDto): Uuid
    {
        $zone                 = new Zone();
        $zone->name           = $createZoneDto->name;
        $zone->price_per_hour = $createZoneDto->pricePerHour;

        if (!$zone->save()) {
            throw new CreateZoneFailedException();
        }

        return Uuid::make($zone->id);
    }
}
