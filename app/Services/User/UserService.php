<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\User\Contracts\UserRepositoryContract;
use App\Services\User\Contracts\UserServiceContract;
use App\Services\User\Dtos\CreateUserDto;

class UserService implements UserServiceContract
{
    public function __construct(private readonly UserRepositoryContract $userRepository)
    {
    }

    /**
     * @inheritDoc
     */
    public function create(CreateUserDto $createUserDto): int
    {
        return $this->userRepository->create($createUserDto);
    }

    /**
     * @inheritDoc
     */
    public function createAccessToken(int $id, ?string $deviceName): string
    {
        $deviceName = substr($deviceName ?? '', 0, 255);

        return $this->userRepository->createAccessToken($id, $deviceName);
    }

    /**
     * @inheritDoc
     */
    public function getOneModelById(int $id): User
    {
        return $this->userRepository->getOneModelById($id);
    }
}
