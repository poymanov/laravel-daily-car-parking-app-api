<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\User\Contracts\UserDtoFormatterContract;
use App\Services\User\Contracts\UserServiceContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProfileController extends Controller
{
    public function __construct(
        private readonly UserServiceContract $userService,
        private readonly UserDtoFormatterContract $userDtoFormatter
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
}
