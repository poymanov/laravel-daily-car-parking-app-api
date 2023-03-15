<?php

namespace App\Services\Vehicle\Services;

use App\Enums\CacheKeysEnum;
use App\Enums\CacheTagsEnum;
use App\Services\Vehicle\Contracts\VehicleCacheServiceContract;
use Closure;
use Illuminate\Cache\Repository;

class VehicleCacheService implements VehicleCacheServiceContract
{
    public function __construct(
        private readonly Repository $cacheService,
        private readonly int $cacheTtl
    ) {
    }

    /**
     * @inheritDoc
     */
    public function forgetAll(int $userId): void
    {
        $this->cacheService->tags($this->getCacheTags($userId))->flush();
    }

    /**
     * @inheritDoc
     */
    public function rememberAndGetAll(int $userId, Closure $closure): array
    {
        //@phpstan-ignore-next-line
        return $this->cacheService->tags($this->getCacheTags($userId))
            ->remember($this->getAllVehiclesCacheKey($userId), $this->cacheTtl, $closure);
    }

    /**
     * @param int $userId
     *
     * @return string
     */
    private function getAllVehiclesCacheKey(int $userId): string
    {
        return CacheKeysEnum::USER_ALL_VEHICLES->value . $userId;
    }

    /**
     * @param int $userId
     *
     * @return string[]
     */
    private function getCacheTags(int $userId): array
    {
        return [CacheTagsEnum::VEHICLES->value . $userId];
    }
}
