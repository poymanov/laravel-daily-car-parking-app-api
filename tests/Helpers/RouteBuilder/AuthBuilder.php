<?php

namespace Tests\Helpers\RouteBuilder;

class AuthBuilder
{
    /**
     * @return string
     */
    public function register(): string
    {
        return '/api/v1/auth/register';
    }

    /**
     * @return string
     */
    public function login(): string
    {
        return '/api/v1/auth/login';
    }

    /**
     * @return string
     */
    public function logout(): string
    {
        return '/api/v1/auth/logout';
    }
}
