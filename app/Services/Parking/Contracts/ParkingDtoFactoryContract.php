<?php

namespace App\Services\Parking\Contracts;

use App\Models\Parking;
use App\Services\Parking\Dtos\ParkingDto;
use Illuminate\Support\Collection;

interface ParkingDtoFactoryContract
{
    /**
     * @param Parking $parking
     *
     * @return ParkingDto
     */
    public function createFromModel(Parking $parking): ParkingDto;

    /**
     * @param Collection $models
     *
     * @return ParkingDto[]
     */
    public function createFromModels(Collection $models): array;
}
