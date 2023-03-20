<?php

namespace Tests\Helpers;

use Tests\Helpers\ModelBuilder\UserBuilder;
use Tests\Helpers\ModelBuilder\VehicleBuilder;
use Tests\Helpers\ModelBuilder\ZoneBuilder;

class ModelBuilderHelper
{
    private static ?ModelBuilderHelper $instance = null;

    public UserBuilder $user;

    public VehicleBuilder $vehicle;

    public ZoneBuilder $zone;

    private function __construct()
    {
        $this->user    = new UserBuilder();
        $this->vehicle = new VehicleBuilder();
        $this->zone    = new ZoneBuilder();
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
