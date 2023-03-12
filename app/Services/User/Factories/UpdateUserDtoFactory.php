<?php

namespace App\Services\User\Factories;

use App\Services\User\Contracts\UpdateUserDtoFactoryContract;
use App\Services\User\Dtos\UpdateUserDto;

class UpdateUserDtoFactory implements UpdateUserDtoFactoryContract
{
    /**
     * @param string $name
     * @param string $email
     *
     * @return UpdateUserDto
     */
    public function createFromParams(string $name, string $email): UpdateUserDto
    {
        $updateUserDto           = new UpdateUserDto();
        $updateUserDto->name     = $name;
        $updateUserDto->email    = $email;

        return $updateUserDto;
    }
}
