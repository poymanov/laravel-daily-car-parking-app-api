<?php

namespace App\Services\Vehicle\Services\VehicleCache;

use App\Enums\CacheKeysEnum;
use App\Services\Vehicle\Contracts\VehicleCacheKeysServiceContract;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class VehicleCacheKeysService implements VehicleCacheKeysServiceContract
{
    /**
     * @inheritDoc
     */
    public function getAllByUserId(int $userId): string
    {
        return CacheKeysEnum::USER_ALL_VEHICLES->value . $userId;
    }

    /**
     * @inheritDoc
     */
    public function getOneById(Uuid $id): string
    {
        return CacheKeysEnum::VEHICLE->value . $id->value();
    }
}
