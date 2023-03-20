<?php

namespace Tests\Helpers;

use Tests\Helpers\RouteBuilder\AuthBuilder;
use Tests\Helpers\RouteBuilder\ProfileBuilder;
use Tests\Helpers\RouteBuilder\VehicleBuilder;
use Tests\Helpers\RouteBuilder\ZoneBuilder;

class RouteBuilderHelper
{
    private static ?RouteBuilderHelper $instance = null;

    public AuthBuilder $auth;

    public ProfileBuilder $profile;

    public VehicleBuilder $vehicle;

    public ZoneBuilder $zone;

    private function __construct()
    {
        $this->auth    = new AuthBuilder();
        $this->profile = new ProfileBuilder();
        $this->vehicle = new VehicleBuilder();
        $this->zone    = new ZoneBuilder();
    }

    public static function getInstance(): RouteBuilderHelper
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}
