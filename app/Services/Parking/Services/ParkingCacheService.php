<?php

namespace App\Services\Parking\Services;

use App\Services\Parking\Contracts\ParkingCacheKeysServiceContract;
use App\Services\Parking\Contracts\ParkingCacheServiceContract;
use App\Services\Parking\Contracts\ParkingCacheTagsServiceContract;
use App\Services\Parking\Dtos\ParkingDto;
use Closure;
use Illuminate\Cache\Repository;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ParkingCacheService implements ParkingCacheServiceContract
{
    public function __construct(
        private readonly Repository $cacheService,
        private readonly ParkingCacheTagsServiceContract $cacheTagsService,
        private readonly ParkingCacheKeysServiceContract $cacheKeysService,
        private readonly int $cacheTtl
    ) {
    }

    /**
     * @return void
     */
    public function forgetAll(): void
    {
        $this->cacheService->tags($this->cacheTagsService->getCacheTags())->flush();
    }

    /**
     * @param Uuid    $id
     * @param Closure $closure
     *
     * @return ParkingDto
     */
    public function rememberAndGetOneById(Uuid $id, Closure $closure): ParkingDto
    {
        //@phpstan-ignore-next-line
        return $this->cacheService->tags($this->cacheTagsService->getCacheTags())
            ->remember($this->cacheKeysService->getOneById($id), $this->cacheTtl, $closure);
    }
}
