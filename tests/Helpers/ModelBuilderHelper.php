<?php

namespace Tests\Helpers;

use Tests\Helpers\ModelBuilder\UserBuilder;
use Tests\Helpers\ModelBuilder\VehicleBuilder;

class ModelBuilderHelper
{
    private static ?ModelBuilderHelper $instance = null;

    public UserBuilder $user;

    public VehicleBuilder $vehicle;

    private function __construct()
    {
        $this->user    = new UserBuilder();
        $this->vehicle = new VehicleBuilder();
    }

    /**
     * @return ModelBuilderHelper
     */
    public static function getInstance(): ModelBuilderHelper
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}
