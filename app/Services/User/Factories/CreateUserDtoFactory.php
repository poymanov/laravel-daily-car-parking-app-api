<?php

namespace App\Services\User\Factories;

use App\Services\User\Contracts\CreateUserDtoFactoryContract;
use App\Services\User\Dtos\CreateUserDto;
use Illuminate\Support\Facades\Hash;

class CreateUserDtoFactory implements CreateUserDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createFromParams(string $name, string $email, string $password): CreateUserDto
    {
        $createUserDto           = new CreateUserDto();
        $createUserDto->name     = $name;
        $createUserDto->email    = $email;
        $createUserDto->password = Hash::make($password);

        return $createUserDto;
    }
}
