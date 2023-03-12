<?php

namespace App\Services\User\Formatters;

use App\Services\User\Contracts\UpdateUserDtoFormatterContract;
use App\Services\User\Dtos\UpdateUserDto;

class UpdateUserDtoFormatter implements UpdateUserDtoFormatterContract
{
    /**
     * @inheritDoc
     */
    public function toArray(UpdateUserDto $dto): array
    {
        return [
            'name'  => $dto->name,
            'email' => $dto->email,
        ];
    }
}
