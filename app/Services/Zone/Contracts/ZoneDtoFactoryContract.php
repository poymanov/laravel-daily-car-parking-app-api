<?php

namespace App\Services\Zone\Contracts;

use App\Models\Zone;
use App\Services\Zone\Dtos\ZoneDto;
use Illuminate\Database\Eloquent\Collection;

interface ZoneDtoFactoryContract
{
    /**
     * @param Zone $zone
     *
     * @return ZoneDto
     */
    public function createFromModel(Zone $zone): ZoneDto;

    /**
     * @param Collection $models
     *
     * @return ZoneDto[]
     */
    public function createFromModels(Collection $models): array;
}
