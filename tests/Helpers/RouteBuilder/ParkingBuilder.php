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
}
