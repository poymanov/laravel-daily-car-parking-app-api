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
}
