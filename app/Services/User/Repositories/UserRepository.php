<?php

namespace App\Services\User\Repositories;

use App\Models\User;
use App\Services\User\Contracts\UserDtoFactoryContract;
use App\Services\User\Contracts\UserRepositoryContract;
use App\Services\User\Dtos\CreateUserDto;
use App\Services\User\Dtos\UpdateUserDto;
use App\Services\User\Dtos\UserDto;
use App\Services\User\Exceptions\CreateUserFailedException;
use App\Services\User\Exceptions\UpdateUserFailedException;
use App\Services\User\Exceptions\UpdateUserPasswordFailedException;
use App\Services\User\Exceptions\UserNotFoundByEmailException;
use App\Services\User\Exceptions\UserNotFoundByIdException;
use Carbon\Carbon;

class UserRepository implements UserRepositoryContract
{
    public function __construct(private readonly UserDtoFactoryContract $userDtoFactory)
    {
    }

    /**
     * @inheritDoc
     */
    public function create(CreateUserDto $createUserDto): int
    {
        $user           = new User();
        $user->name     = $createUserDto->name;
        $user->email    = $createUserDto->email;
        $user->password = $createUserDto->password;

        if (!$user->save()) {
            throw new CreateUserFailedException();
        }

        return $user->id;
    }

    /**
     * @param int           $id
     * @param UpdateUserDto $updateUserDto
     *
     * @return void
     * @throws UpdateUserFailedException
     * @throws UserNotFoundByIdException
     */
    public function update(int $id, UpdateUserDto $updateUserDto): void
    {
        $user = $this->getOneModelById($id);
        $user->name = $updateUserDto->name;
        $user->email = $updateUserDto->email;

        if (!$user->save()) {
            throw new UpdateUserFailedException($id);
        }
    }

    /**
     * @param int    $id
     * @param string $passwordHash
     *
     * @return void
     * @throws UpdateUserPasswordFailedException
     * @throws UserNotFoundByIdException
     */
    public function updatePassword(int $id, string $passwordHash): void
    {
        $user = $this->getOneModelById($id);
        $user->password = $passwordHash;

        if (!$user->save()) {
            throw new UpdateUserPasswordFailedException($id);
        }
    }

    /**
     * @inheritDoc
     */
    public function createAccessToken(int $id, string $deviceName, ?Carbon $expiredAt): string
    {
        $user = $this->getOneModelById($id);

        return $user->createToken($deviceName, ['*'], $expiredAt)->plainTextToken;
    }

    /**
     * @inheritDoc
     */
    public function deleteAccessTokens(int $id): void
    {
        $user = $this->getOneModelById($id);

        $user->tokens()->delete();
    }

    /**
     * @inheritDoc
     */
    public function getOneModelById(int $id): User
    {
        $user = User::find($id);

        if (is_null($user)) {
            throw new UserNotFoundByIdException($id);
        }

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function getOneById(int $id): UserDto
    {
        $user = $this->getOneModelById($id);

        return $this->userDtoFactory->createFromModel($user);
    }

    /**
     * @inheritDoc
     */
    public function getOneModelByEmail(string $email): User
    {
        $user = User::whereEmail($email)->first();

        if (is_null($user)) {
            throw new UserNotFoundByEmailException($email);
        }

        return $user;
    }
}
