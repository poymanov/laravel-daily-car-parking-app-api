<?php

namespace App\Services\Parking\Contracts;

use App\Models\Parking;
use App\Services\Parking\Dtos\ParkingDto;

interface ParkingDtoFactoryContract
{
    /**
     * @param Parking $parking
     *
     * @return ParkingDto
     */
    public function createFromModel(Parking $parking): ParkingDto;
}
