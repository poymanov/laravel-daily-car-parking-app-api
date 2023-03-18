<?php

namespace App\Services\Vehicle\Services\VehicleCache;

use App\Enums\CacheTagsEnum;
use App\Services\Vehicle\Contracts\VehicleCacheTagsServiceContract;

class VehicleCacheTagsService implements VehicleCacheTagsServiceContract
{
    /**
     * @param int|null $userId
     *
     * @return string[]
     */
    public function getCacheTags(?int $userId = null): array
    {
        return [CacheTagsEnum::VEHICLES->value];
    }
}
