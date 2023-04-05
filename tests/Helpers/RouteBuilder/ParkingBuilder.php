<?php

namespace Tests\Helpers\RouteBuilder;

class ParkingBuilder
{
    /**
     * @return string
     */
    public function start(): string
    {
        return '/api/v1/parkings';
    }

    /**
     * @param string $id
     *
     * @return string
     */
    public function stop(string $id): string
    {
        return '/api/v1/parkings/' . $id;
    }

    /**
     * @param string $id
     *
     * @return string
     */
    public function show(string $id): string
    {
        return '/api/v1/parkings/' . $id;
    }

    /**
     * @return string
     */
    public function active(): string
    {
        return '/api/v1/parkings/active';
    }

    /**
     * @return string
     */
    public function stopped(): string
    {
        return '/api/v1/parkings/stopped';
    }
}
