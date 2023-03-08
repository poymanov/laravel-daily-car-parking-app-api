<?php

namespace App\Services\User\Contracts;

use App\Models\User;
use App\Services\User\Dtos\CreateUserDto;
use App\Services\User\Exceptions\CreateUserFailedException;
use App\Services\User\Exceptions\UserNotFoundException;

interface UserRepositoryContract
{
    /**
     * Создание пользователя
     *
     * @param CreateUserDto $createUserDto
     *
     * @return int
     * @throws CreateUserFailedException
     */
    public function create(CreateUserDto $createUserDto): int;

    /**
     * Создание токена авторизации пользователя
     *
     * @param int    $id
     * @param string $deviceName
     *
     * @return string
     * @throws UserNotFoundException
     */
    public function createAccessToken(int $id, string $deviceName): string;

    /**
     * @param int $id
     *
     * @return User
     * @throws UserNotFoundException
     */
    public function getOneModelById(int $id): User;
}
