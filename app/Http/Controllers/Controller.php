<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    /**
     * @param Request $request
     *
     * @return int
     */
    protected function getAuthUserId(Request $request): int
    {
        if (is_null($request->user())) {
            throw new BadRequestHttpException('Auth user not found');
        }

        return $request->user()->id;
    }
}
