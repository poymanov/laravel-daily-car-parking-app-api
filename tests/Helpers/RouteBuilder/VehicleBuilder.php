<?php

namespace Tests\Helpers\RouteBuilder;

class VehicleBuilder
{
    /**
     * @return string
     */
    public function index(): string
    {
        return '/api/v1/vehicles';
    }

    /**
     * @return string
     */
    public function store(): string
    {
        return '/api/v1/vehicles';
    }
}
