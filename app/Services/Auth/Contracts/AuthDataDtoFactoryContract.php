<?php

namespace App\Services\Auth\Contracts;

use App\Services\Auth\Dtos\AuthDataDto;

interface AuthDataDtoFactoryContract
{
    public function createFromParams(
        string $email,
        string $password,
        bool $remember,
        ?string $deviceName
    ): AuthDataDto;
}
