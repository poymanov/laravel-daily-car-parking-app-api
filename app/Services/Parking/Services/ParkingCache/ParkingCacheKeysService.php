<?php

namespace App\Services\Parking\Services\ParkingCache;

use App\Enums\CacheKeysEnum;
use App\Services\Parking\Contracts\ParkingCacheKeysServiceContract;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ParkingCacheKeysService implements ParkingCacheKeysServiceContract
{
    /**
     * @inheritDoc
     */
    public function getOneById(Uuid $id): string
    {
        return CacheKeysEnum::PARKING->value . $id->value();
    }

    /**
     * @inheritDoc
     */
    public function getAllStoppedByUserId(int $userId): string
    {
        return CacheKeysEnum::PARKING->value . 'stopped-user-id'  . $userId;
    }
}
