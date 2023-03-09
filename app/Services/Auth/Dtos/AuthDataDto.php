<?php

namespace App\Services\Auth\Dtos;

class AuthDataDto
{
    public string $email;

    public string $password;

    public bool $remember;

    public ?string $deviceName;
}
