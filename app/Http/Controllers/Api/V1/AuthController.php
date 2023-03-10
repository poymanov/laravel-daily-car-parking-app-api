<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\Contracts\AuthDataDtoFactoryContract;
use App\Services\Auth\Contracts\AuthServiceContract;
use App\Services\User\Contracts\CreateUserDtoFactoryContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

class AuthController extends Controller
{
    public function __construct(
        private readonly CreateUserDtoFactoryContract $createUserDtoFactory,
        private readonly AuthDataDtoFactoryContract $authDataDtoFactory,
        private readonly AuthServiceContract $authService
    ) {
    }

    /**
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws Throwable
     * @throws \App\Services\User\Exceptions\CreateUserFailedException
     * @throws \App\Services\User\Exceptions\UserNotFoundByIdException
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $createUserDto = $this->createUserDtoFactory->createFromParams(
                $request->get('name'),
                $request->get('email'),
                $request->get('password')
            );

            $accessToken = $this->authService->register($createUserDto, $request->userAgent());

            return response()->json([
                'access_token' => $accessToken,
            ], Response::HTTP_CREATED);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param LoginRequest $request
     *
     * @return JsonResponse
     * @throws Throwable
     * @throws \App\Services\Auth\Exceptions\CredentionalsIncorrectException
     * @throws \App\Services\User\Exceptions\UserNotFoundByEmailException
     * @throws \App\Services\User\Exceptions\UserNotFoundByIdException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $authDataDto = $this->authDataDtoFactory->createFromParams(
                $request->get('email'),
                $request->get('password'),
                $request->exists('remember'),
                $request->userAgent()
            );

            $accessToken = $this->authService->login($authDataDto);

            return response()->json([
                'access_token' => $accessToken,
            ], Response::HTTP_CREATED);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @throws Throwable
     * @throws \App\Services\User\Exceptions\UserNotFoundByIdException
     */
    public function logout(Request $request)
    {
        try {
            if (is_null($request->user())) {
                throw new BadRequestHttpException('Auth user not found');
            }

            $this->authService->logout($request->user()->id);

            return response()->noContent();
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
