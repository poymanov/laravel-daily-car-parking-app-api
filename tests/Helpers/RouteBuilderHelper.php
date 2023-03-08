<?php

namespace Tests\Helpers;

use Tests\Helpers\RouteBuilder\AuthBuilder;

class RouteBuilderHelper
{
    private static ?RouteBuilderHelper $instance = null;

    public AuthBuilder $auth;

    private function __construct()
    {
        $this->auth = new AuthBuilder();
    }

    public static function getInstance(): RouteBuilderHelper
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}
