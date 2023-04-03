<?php

namespace App\Services\Vehicle\Contracts;

use App\Services\Vehicle\Dtos\VehicleCreateDto;

interface VehicleCreateDtoFactoryContract
{
    /**
     * @param string $plateNumber
     * @param string $description
     *
     * @return VehicleCreateDto
     */
    public function createFromParam(string $plateNumber, string $description): VehicleCreateDto;
}
