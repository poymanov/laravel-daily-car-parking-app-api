<?php

namespace Tests\Helpers;

use Tests\Helpers\ModelBuilder\UserBuilder;

class ModelBuilderHelper
{
    private static ?ModelBuilderHelper $instance = null;

    public UserBuilder $user;

    private function __construct()
    {
        $this->user = new UserBuilder();
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
