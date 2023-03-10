<?php

namespace App\Services\Auth;

use App\Services\Auth\Contracts\AuthServiceContract;
use App\Services\Auth\Dtos\AuthDataDto;
use App\Services\Auth\Exceptions\CredentionalsIncorrectException;
use App\Services\User\Contracts\UserServiceContract;
use App\Services\User\Dtos\CreateUserDto;
use App\Services\User\Exceptions\CreateUserFailedException;
use App\Services\User\Exceptions\UserNotFoundByIdException;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthService implements AuthServiceContract
{
    public function __construct(
        private readonly UserServiceContract $userService,
        private readonly int $tokenLifetimeInMinutes
    ) {
    }

    /**
     * @param CreateUserDto $createUserDto
     * @param string|null   $deviceName
     *
     * @return string
     * @throws CreateUserFailedException
     * @throws UserNotFoundByIdException
     */
    public function register(CreateUserDto $createUserDto, ?string $deviceName): string
    {
        $createdUserId = $this->userService->create($createUserDto);

        $user = $this->userService->getOneModelById($createdUserId);

        event(new Registered($user));

        $tokenExpiresAt = $this->getTokenExpiresDate();

        return $this->userService->createAccessToken($createdUserId, $deviceName, $tokenExpiresAt);
    }

    /**
     * @inheritDoc
     */
    public function login(AuthDataDto $authUserDto): string
    {
        try {
            $user = $this->userService->getOneModelByEmail($authUserDto->email);
        } catch (Throwable) {
            throw new CredentionalsIncorrectException();
        }

        if (!Hash::check($authUserDto->password, $user->password)) {
            throw new CredentionalsIncorrectException();
        }

        $tokenExpiresAt = $authUserDto->remember ? null : $this->getTokenExpiresDate();

        return $this->userService->createAccessToken($user->id, $authUserDto->deviceName, $tokenExpiresAt);
    }

    /**
     * @param int $userId
     *
     * @return void
     * @throws UserNotFoundByIdException
     */
    public function logout(int $userId): void
    {
        $this->userService->deleteAccessTokens($userId);
    }

    /**
     * @return Carbon
     */
    private function getTokenExpiresDate(): Carbon
    {
        return (now())->addMinutes($this->tokenLifetimeInMinutes);
    }
}
