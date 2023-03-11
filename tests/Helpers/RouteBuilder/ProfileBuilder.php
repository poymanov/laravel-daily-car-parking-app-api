<?php

namespace Tests\Helpers\RouteBuilder;

class ProfileBuilder
{
    /**
     * @return string
     */
    public function show(): string
    {
        return '/api/v1/profile';
    }
}
