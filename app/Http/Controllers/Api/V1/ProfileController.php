<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Http\Requests\Profile\UpdateRequest;
use App\Services\User\Contracts\UpdateUserDtoFactoryContract;
use App\Services\User\Contracts\UpdateUserDtoFormatterContract;
use App\Services\User\Contracts\UserDtoFormatterContract;
use App\Services\User\Contracts\UserServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProfileController extends Controller
{
    public function __construct(
        private readonly UserServiceContract $userService,
        private readonly UserDtoFormatterContract $userDtoFormatter,
        private readonly UpdateUserDtoFactoryContract $updateUserDtoFactory,
        private readonly UpdateUserDtoFormatterContract $updateUserDtoFormatter
    ) {
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Throwable
     * @throws \App\Services\User\Exceptions\UserNotFoundByIdException
     */
    public function show(Request $request): JsonResponse
    {
        try {
            $authUserId = $this->getAuthUserId($request);

            $user = $this->userService->getOneById($authUserId);

            $userFormatted = $this->userDtoFormatter->toArray($user);

            return response()->json($userFormatted);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param UpdateRequest $request
     *
     * @return JsonResponse
     * @throws Throwable
     * @throws \App\Services\User\Exceptions\UpdateUserFailedException
     * @throws \App\Services\User\Exceptions\UserNotFoundByIdException
     */
    public function update(UpdateRequest $request): JsonResponse
    {
        try {
            $authUserId = $this->getAuthUserId($request);

            $updateUserDto = $this->updateUserDtoFactory->createFromParams(
                $request->get('name'),
                $request->get('email')
            );

            $this->userService->update($authUserId, $updateUserDto);

            $updateUserDtoFormatted = $this->updateUserDtoFormatter->toArray($updateUserDto);

            return response()->json($updateUserDtoFormatted);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param UpdatePasswordRequest $request
     *
     * @return Response
     * @throws Throwable
     * @throws \App\Services\User\Exceptions\UpdateUserPasswordFailedException
     * @throws \App\Services\User\Exceptions\UserNotFoundByIdException
     */
    public function updatePassword(UpdatePasswordRequest $request): Response
    {
        try {
            $authUserId = $this->getAuthUserId($request);

            $this->userService->updatePassword($authUserId, $request->get('password'));

            return response()->noContent();
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
