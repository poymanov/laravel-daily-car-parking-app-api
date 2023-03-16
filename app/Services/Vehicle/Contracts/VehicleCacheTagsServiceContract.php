<?php

namespace App\Services\Vehicle\Contracts;

interface VehicleCacheTagsServiceContract
{
    /**
     * @param int|null $userId
     *
     * @return string[]
     */
    public function getCacheTags(?int $userId = null): array;
}
