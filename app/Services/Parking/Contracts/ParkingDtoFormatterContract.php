<?php

namespace App\Services\Parking\Contracts;

use App\Services\Parking\Dtos\ParkingDto;

interface ParkingDtoFormatterContract
{
    /**
     * @param ParkingDto $dto
     *
     * @return array
     */
    public function toArray(ParkingDto $dto): array;

    /**
     * @param array $dtos
     *
     * @return array
     */
    public function fromArrayToArray(array $dtos): array;
}
