<?php

namespace App\Services\Parking\Contracts;

interface ParkingCacheTagsServiceContract
{
    /**
     * @return string[]
     */
    public function getCacheTags(): array;
}
