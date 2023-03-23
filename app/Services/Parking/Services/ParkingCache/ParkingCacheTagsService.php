<?php

namespace App\Services\Parking\Services\ParkingCache;

use App\Enums\CacheTagsEnum;
use App\Services\Parking\Contracts\ParkingCacheTagsServiceContract;

class ParkingCacheTagsService implements ParkingCacheTagsServiceContract
{
    /**
     * @inheritDoc
     */
    public function getCacheTags(): array
    {
        return [CacheTagsEnum::PARKINGS->value];
    }
}
