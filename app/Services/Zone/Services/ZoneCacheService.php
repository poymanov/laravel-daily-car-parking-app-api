<?php

namespace App\Services\Zone\Services;

use App\Services\Zone\Contracts\ZoneCacheServiceContract;
use App\Services\Zone\Contracts\ZoneCacheTagsServiceContract;
use Illuminate\Cache\Repository;

class ZoneCacheService implements ZoneCacheServiceContract
{
    public function __construct(
        private readonly Repository $cacheService,
        private readonly ZoneCacheTagsServiceContract $cacheTagsService
    ) {
    }

    /**
     * @return void
     */
    public function forgetAll(): void
    {
        $this->cacheService->tags($this->cacheTagsService->getCacheTags())->flush();
    }
}
