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

    /**
     * @param string $id
     *
     * @return string
     */
    public function show(string $id): string
    {
        return '/api/v1/vehicles/' . $id;
    }
}
