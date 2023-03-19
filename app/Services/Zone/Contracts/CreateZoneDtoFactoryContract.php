<?php

namespace App\Services\Zone\Contracts;

use App\Services\Zone\Dtos\CreateZoneDto;

interface CreateZoneDtoFactoryContract
{
    /**
     * @param string $name
     * @param int    $pricePerHour
     *
     * @return CreateZoneDto
     */
    public function createFromParams(string $name, int $pricePerHour): CreateZoneDto;
}
