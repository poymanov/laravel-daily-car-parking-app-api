<?php

namespace App\Services\Vehicle\Services;

use App\Services\Vehicle\Contracts\VehicleCacheKeysServiceContract;
use App\Services\Vehicle\Contracts\VehicleCacheServiceContract;
use App\Services\Vehicle\Contracts\VehicleCacheTagsServiceContract;
use App\Services\Vehicle\Dtos\VehicleDto;
use Closure;
use Illuminate\Cache\Repository;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class VehicleCacheService implements VehicleCacheServiceContract
{
    public function __construct(
        private readonly Repository $cacheService,
        private readonly VehicleCacheTagsServiceContract $vehicleCacheTagsService,
        private readonly VehicleCacheKeysServiceContract $vehicleCacheKeysService,
        private readonly int $cacheTtl
    ) {
    }

    /**
     * @inheritDoc
     */
    public function forgetAll(int $userId): void
    {
        $this->cacheService->tags($this->vehicleCacheTagsService->getCacheTags($userId))->flush();
    }

    /**
     * @inheritDoc
     */
    public function rememberAndGetAllByUserId(int $userId, Closure $closure): array
    {
        //@phpstan-ignore-next-line
        return $this->cacheService->tags($this->vehicleCacheTagsService->getCacheTags($userId))
            ->remember($this->vehicleCacheKeysService->getAllByUserId($userId), $this->cacheTtl, $closure);
    }

    /**
     * @inheritDoc
     */
    public function rememberAndGetOneById(Uuid $id, Closure $closure): VehicleDto
    {
        //@phpstan-ignore-next-line
        return $this->cacheService->tags($this->vehicleCacheTagsService->getCacheTags())
            ->remember($this->vehicleCacheKeysService->getOneById($id), $this->cacheTtl, $closure);
    }
}
