<?php

namespace App\Services\User\Contracts;

use App\Services\User\Dtos\UpdateUserDto;

interface UpdateUserDtoFactoryContract
{
    /**
     * @param string $name
     * @param string $email
     *
     * @return UpdateUserDto
     */
    public function createFromParams(string $name, string $email): UpdateUserDto;
}
