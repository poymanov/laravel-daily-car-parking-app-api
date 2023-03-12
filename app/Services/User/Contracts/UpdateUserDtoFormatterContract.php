<?php

namespace App\Services\User\Contracts;

use App\Services\User\Dtos\UpdateUserDto;

interface UpdateUserDtoFormatterContract
{
    /**
     * @param UpdateUserDto $dto
     *
     * @return array
     */
    public function toArray(UpdateUserDto $dto): array;
}
