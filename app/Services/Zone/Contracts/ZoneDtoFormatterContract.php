<?php

namespace App\Services\Zone\Contracts;

use App\Services\Zone\Dtos\ZoneDto;

interface ZoneDtoFormatterContract
{
    /**
     * @param ZoneDto $dto
     *
     * @return array
     */
    public function toArray(ZoneDto $dto): array;

    /**
     * @param array $dtos
     *
     * @return array
     */
    public function fromArrayToArray(array $dtos): array;
}
