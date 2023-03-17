<?php

namespace App\Services\Vehicle\Contracts;

use App\Services\Vehicle\Dtos\VehicleUpdateDto;

interface VehicleUpdateDtoFactoryContract
{
    /**
     * @param string $plateNumber
     *
     * @return VehicleUpdateDto
     */
    public function createFromParam(string $plateNumber): VehicleUpdateDto;
}
