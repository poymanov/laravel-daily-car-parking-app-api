<?php

namespace App\Services\Parking\Contracts;

use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ParkingCacheKeysServiceContract
{
    /**
     * @param Uuid $id
     *
     * @return string
     */
    public function getOneById(Uuid $id): string;

    /**
     * @param int $userId
     *
     * @return string
     */
    public function getAllStoppedByUserId(int $userId): string;
}
