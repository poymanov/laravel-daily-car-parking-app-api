<?php

namespace App\Services\Auth\Factories;

use App\Services\Auth\Contracts\AuthDataDtoFactoryContract;
use App\Services\Auth\Dtos\AuthDataDto;

class AuthDataDtoFactory implements AuthDataDtoFactoryContract
{
    public function createFromParams(
        string $email,
        string $password,
        bool $remember,
        ?string $deviceName
    ): AuthDataDto {
        $authDataDto = new AuthDataDto();
        $authDataDto->email = $email;
        $authDataDto->password = $password;
        $authDataDto->remember = $remember;
        $authDataDto->deviceName = $deviceName;

        return $authDataDto;
    }
}
