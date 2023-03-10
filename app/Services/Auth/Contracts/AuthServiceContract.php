<?php

namespace App\Services\Auth\Contracts;

use App\Services\Auth\Dtos\AuthDataDto;
use App\Services\Auth\Exceptions\CredentionalsIncorrectException;
use App\Services\User\Dtos\CreateUserDto;
use App\Services\User\Exceptions\CreateUserFailedException;
use App\Services\User\Exceptions\UserNotFoundByEmailException;
use App\Services\User\Exceptions\UserNotFoundByIdException;

interface AuthServiceContract
{
    /**
     * @param CreateUserDto $createUserDto
     * @param string|null   $deviceName
     *
     * @return string
     * @throws CreateUserFailedException
     * @throws UserNotFoundByIdException
     */
    public function register(CreateUserDto $createUserDto, ?string $deviceName): string;

    /**
     * @param AuthDataDto $authUserDto
     *
     * @return string
     * @throws CredentionalsIncorrectException
     * @throws UserNotFoundByIdException
     * @throws UserNotFoundByEmailException
     */
    public function login(AuthDataDto $authUserDto): string;

    /**
     * @param int $userId
     *
     * @return void
     * @throws UserNotFoundByIdException
     */
    public function logout(int $userId): void;
}
