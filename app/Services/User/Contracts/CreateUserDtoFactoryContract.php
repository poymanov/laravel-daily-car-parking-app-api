<?php

namespace App\Services\User\Contracts;

use App\Services\User\Dtos\CreateUserDto;

interface CreateUserDtoFactoryContract
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @return CreateUserDto
     */
    public function createFromParams(string $name, string $email, string $password): CreateUserDto;
}
