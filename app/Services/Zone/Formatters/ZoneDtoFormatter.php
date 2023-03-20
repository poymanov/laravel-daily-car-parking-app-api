<?php

namespace App\Services\Zone\Formatters;

use App\Services\Zone\Contracts\ZoneDtoFormatterContract;
use App\Services\Zone\Dtos\ZoneDto;

class ZoneDtoFormatter implements ZoneDtoFormatterContract
{
    /**
     * @inheritDoc
     */
    public function toArray(ZoneDto $dto): array
    {
        return [
            'id'             => $dto->id->value(),
            'name'           => $dto->name,
            'price_per_hour' => $dto->pricePerHour,
        ];
    }

    /**
     * @inheritDoc
     */
    public function fromArrayToArray(array $dtos): array
    {
        $result = [];

        foreach ($dtos as $dto) {
            $result[] = $this->toArray($dto);
        }

        return $result;
    }
}
