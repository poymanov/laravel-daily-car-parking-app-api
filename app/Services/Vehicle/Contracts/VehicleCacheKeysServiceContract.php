<?php

namespace App\Services\Vehicle\Contracts;

use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface VehicleCacheKeysServiceContract
{
    /**
     * @param int $userId
     *
     * @return string
     */
    public function getAllByUserId(int $userId): string;

    /**
     * @param Uuid $id
     *
     * @return string
     */
    public function getOneById(Uuid $id): string;
}
