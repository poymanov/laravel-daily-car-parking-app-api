<?php

namespace App\Services\Zone\Services;

use App\Services\Zone\Contracts\ZoneCacheKeysServiceContract;
use App\Services\Zone\Contracts\ZoneCacheServiceContract;
use App\Services\Zone\Contracts\ZoneCacheTagsServiceContract;
use Closure;
use Illuminate\Cache\Repository;

class ZoneCacheService implements ZoneCacheServiceContract
{
    public function __construct(
        private readonly Repository $cacheService,
        private readonly ZoneCacheTagsServiceContract $cacheTagsService,
        private readonly ZoneCacheKeysServiceContract $cacheKeysService,
        private readonly int $cacheTtl
    ) {
    }

    /**
     * @inheritDoc
     */
    public function forgetAll(): void
    {
        $this->cacheService->tags($this->cacheTagsService->getCacheTags())->flush();
    }

    /**
     * @inheritDoc
     */
    public function rememberAndGetAll(Closure $closure): array
    {
        //@phpstan-ignore-next-line
        return $this->cacheService->tags($this->cacheTagsService->getCacheTags())
            ->remember($this->cacheKeysService->getAll(), $this->cacheTtl, $closure);
    }
}
