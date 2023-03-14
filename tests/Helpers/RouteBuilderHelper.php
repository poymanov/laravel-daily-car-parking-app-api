<?php

namespace Tests\Helpers;

use Tests\Helpers\RouteBuilder\AuthBuilder;
use Tests\Helpers\RouteBuilder\ProfileBuilder;
use Tests\Helpers\RouteBuilder\VehicleBuilder;

class RouteBuilderHelper
{
    private static ?RouteBuilderHelper $instance = null;

    public AuthBuilder    $auth;

    public ProfileBuilder $profile;

    public VehicleBuilder $vehicle;

    private function __construct()
    {
        $this->auth    = new AuthBuilder();
        $this->profile = new ProfileBuilder();
        $this->vehicle = new VehicleBuilder();
    }

    public static function getInstance(): RouteBuilderHelper
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}
