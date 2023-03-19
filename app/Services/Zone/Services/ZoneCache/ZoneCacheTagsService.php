<?php

namespace App\Services\Zone\Services\ZoneCache;

use App\Enums\CacheTagsEnum;
use App\Services\Zone\Contracts\ZoneCacheTagsServiceContract;

class ZoneCacheTagsService implements ZoneCacheTagsServiceContract
{
    /**
     * @inheritDoc
     */
    public function getCacheTags(): array
    {
        return [CacheTagsEnum::ZONES->value];
    }
}
