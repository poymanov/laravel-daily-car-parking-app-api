<?php

namespace App\Services\Vehicle\Contracts;

use App\Services\Vehicle\Dtos\VehicleDto;

interface VehicleDtoFormatterContract
{
    /**
     * @param VehicleDto $dto
     *
     * @return array
     */
    public function toArray(VehicleDto $dto): array;

    /**
     * @param VehicleDto[] $dtos
     *
     * @return array
     */
    public function fromArrayToArray(array $dtos): array;
}
