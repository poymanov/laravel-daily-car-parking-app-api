<?php

namespace App\Services\User\Formatters;

use App\Services\User\Contracts\UserDtoFormatterContract;
use App\Services\User\Dtos\UserDto;

class UserDtoFormatter implements UserDtoFormatterContract
{
    /**
     * @inheritDoc
     */
    public function toArray(UserDto $dto): array
    {
        return [
            'id' => $dto->id,
            'name' => $dto->name,
            'email' => $dto->email
        ];
    }
}
