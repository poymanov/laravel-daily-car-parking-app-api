<?php

namespace App\Services\Vehicle\Contracts;

interface VehicleCacheTagsServiceContract
{
    /**
     * @return string[]
     */
    public function getCacheTags(): array;
}
