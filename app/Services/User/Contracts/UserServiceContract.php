<?php

namespace App\Services\User\Contracts;

use App\Models\User;
use App\Services\User\Dtos\CreateUserDto;
use App\Services\User\Dtos\UpdateUserDto;
use App\Services\User\Dtos\UserDto;
use App\Services\User\Exceptions\CreateUserFailedException;
use App\Services\User\Exceptions\UpdateUserFailedException;
use App\Services\User\Exceptions\UpdateUserPasswordFailedException;
use App\Services\User\Exceptions\UserNotFoundByEmailException;
use App\Services\User\Exceptions\UserNotFoundByIdException;
use Carbon\Carbon;

interface UserServiceContract
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
     * @param int           $id
     * @param UpdateUserDto $updateUserDto
     *
     * @return void
     * @throws UpdateUserFailedException
     * @throws UserNotFoundByIdException
     */
    public function update(int $id, UpdateUserDto $updateUserDto): void;

    /**
     * @param int    $id
     * @param string $password
     *
     * @return void
     * @throws UpdateUserPasswordFailedException
     * @throws UserNotFoundByIdException
     */
    public function updatePassword(int $id, string $password): void;

    /**
     * Получение пользователя по ID в виде объекта модели
     *
     * @param int $id
     *
     * @return User
     * @throws UserNotFoundByIdException
     */
    public function getOneModelById(int $id): User;

    /**
     * @param string $email
     *
     * @return User
     * @throws UserNotFoundByEmailException
     */
    public function getOneModelByEmail(string $email): User;

    /**
     * Получение пользователя по ID в виде объекта Dto
     *
     * @param int $id
     *
     * @return UserDto
     * @throws UserNotFoundByIdException
     */
    public function getOneById(int $id): UserDto;

    /**
     * @param int         $id
     * @param string|null $deviceName
     * @param Carbon|null $expiredAt
     *
     * @return string
     * @throws UserNotFoundByIdException
     */
    public function createAccessToken(int $id, ?string $deviceName, ?Carbon $expiredAt): string;

    /**
     * Удаление авторизационных токенов пользователей
     *
     * @param int $id
     *
     * @return void
     * @throws UserNotFoundByIdException
     */
    public function deleteAccessTokens(int $id): void;
}
