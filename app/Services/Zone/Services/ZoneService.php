<?php

namespace App\Services\Zone\Services;

use App\Services\Zone\Contracts\ZoneCacheServiceContract;
use App\Services\Zone\Contracts\ZoneRepositoryContract;
use App\Services\Zone\Contracts\ZoneServiceContract;
use App\Services\Zone\Dtos\CreateZoneDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ZoneService implements ZoneServiceContract
{
    public function __construct(
        private readonly ZoneRepositoryContract $zoneRepository,
        private readonly ZoneCacheServiceContract $zoneCacheService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(CreateZoneDto $createZoneDto): Uuid
    {
        $id = $this->zoneRepository->create($createZoneDto);

        $this->zoneCacheService->forgetAll();

        return $id;
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        return $this->zoneCacheService->rememberAndGetAll(function () {
            return $this->zoneRepository->findAll();
        });
    }
}
