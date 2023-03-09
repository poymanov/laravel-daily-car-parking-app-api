<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\User\Contracts\UserRepositoryContract;
use App\Services\User\Contracts\UserServiceContract;
use App\Services\User\Dtos\CreateUserDto;
use App\Services\User\Exceptions\UserNotFoundByIdException;
use Carbon\Carbon;

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
    public function getOneModelById(int $id): User
    {
        return $this->userRepository->getOneModelById($id);
    }

    /**
     * @inheritDoc
     */
    public function getOneModelByEmail(string $email): User
    {
        return $this->userRepository->getOneModelByEmail($email);
    }

    /**
     * @param int         $id
     * @param string|null $deviceName
     *
     * @return string
     * @throws UserNotFoundByIdException
     */
    public function createAccessToken(int $id, ?string $deviceName, ?Carbon $expiredAt): string
    {
        $deviceName = substr($deviceName ?? '', 0, 255);

        return $this->userRepository->createAccessToken($id, $deviceName, $expiredAt);
    }
}
