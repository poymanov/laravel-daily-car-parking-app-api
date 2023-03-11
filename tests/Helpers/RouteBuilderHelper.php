<?php

namespace Tests\Helpers;

use Tests\Helpers\RouteBuilder\AuthBuilder;
use Tests\Helpers\RouteBuilder\ProfileBuilder;

class RouteBuilderHelper
{
    private static ?RouteBuilderHelper $instance = null;

    public AuthBuilder    $auth;
    public ProfileBuilder $profile;

    private function __construct()
    {
        $this->auth    = new AuthBuilder();
        $this->profile = new ProfileBuilder();
    }

    public static function getInstance(): RouteBuilderHelper
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}
