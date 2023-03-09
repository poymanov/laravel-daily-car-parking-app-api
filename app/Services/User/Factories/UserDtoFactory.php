<?php

namespace App\Services\User\Factories;

use App\Models\User;
use App\Services\User\Contracts\UserDtoFactoryContract;
use App\Services\User\Dtos\UserDto;

class UserDtoFactory implements UserDtoFactoryContract
{
    /**
     * @param User $user
     *
     * @return UserDto
     */
    public function createFromModel(User $user): UserDto
    {
        $userDto              = new UserDto();
        $userDto->id          = $user->id;
        $userDto->email       = $user->email;
        $userDto->name        = $user->name;

        return $userDto;
    }
}
