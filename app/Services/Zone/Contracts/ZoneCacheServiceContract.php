<?php

namespace App\Services\Zone\Contracts;

interface ZoneCacheServiceContract
{
    /**
     * @return void
     */
    public function forgetAll(): void;
}
