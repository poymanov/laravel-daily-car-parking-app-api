<?php

namespace App\Services\User\Contracts;

use App\Services\User\Dtos\UserDto;

interface UserDtoFormatterContract
{
    /**
     * @param UserDto $dto
     *
     * @return array
     */
    public function toArray(UserDto $dto): array;
}
