<?php

namespace App\Services\Vehicle\Contracts;

use App\Services\Vehicle\Dtos\VehicleUpdateDto;

interface VehicleUpdateDtoFactoryContract
{
    /**
     * @param string      $plateNumber
     * @param string|null $description
     *
     * @return VehicleUpdateDto
     */
    public function createFromParam(string $plateNumber, ?string $description): VehicleUpdateDto;
}
