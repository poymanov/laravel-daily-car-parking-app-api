<?php

namespace App\Services\User\Repositories;

use App\Models\User;
use App\Services\User\Contracts\UserRepositoryContract;
use App\Services\User\Dtos\CreateUserDto;
use App\Services\User\Exceptions\CreateUserFailedException;
use App\Services\User\Exceptions\UserNotFoundException;

class UserRepository implements UserRepositoryContract
{
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
     * @inheritDoc
     */
    public function createAccessToken(int $id, string $deviceName): string
    {
        $user = $this->getOneModelById($id);

        return $user->createToken($deviceName)->plainTextToken;
    }

    /**
     * @inheritDoc
     */
    public function getOneModelById(int $id): User
    {
        $user = User::find($id);

        if (is_null($user)) {
            throw new UserNotFoundException($id);
        }

        return $user;
    }
}
