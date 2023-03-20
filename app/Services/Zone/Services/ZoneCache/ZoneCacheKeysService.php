<?php

namespace App\Services\Zone\Services\ZoneCache;

use App\Enums\CacheKeysEnum;
use App\Services\Zone\Contracts\ZoneCacheKeysServiceContract;

class ZoneCacheKeysService implements ZoneCacheKeysServiceContract
{
    /**
     * @inheritDoc
     */
    public function getAll(): string
    {
        return CacheKeysEnum::ZONES->value;
    }
}
