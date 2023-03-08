<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\User\Contracts\CreateUserDtoFactoryContract;
use App\Services\User\Contracts\UserServiceContract;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserServiceContract $userService,
        private readonly CreateUserDtoFactoryContract $createUserDtoFactory
    ) {
    }

    /**
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws Throwable
     * @throws \App\Services\User\Exceptions\CreateUserFailedException
     * @throws \App\Services\User\Exceptions\UserNotFoundException
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $createUserDto = $this->createUserDtoFactory->createFromParams(
                $request->get('name'),
                $request->get('email'),
                $request->get('password')
            );

            $createdUserId = $this->userService->create($createUserDto);

            $user = $this->userService->getOneModelById($createdUserId);

            event(new Registered($user));

            $accessToken = $this->userService->createAccessToken($createdUserId, $request->userAgent());

            return response()->json([
                'access_token' => $accessToken,
            ], Response::HTTP_CREATED);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
