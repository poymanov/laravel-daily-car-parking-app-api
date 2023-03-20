<?php

namespace App\Services\Zone\Contracts;

interface ZoneCacheKeysServiceContract
{
    /**
     * @return string
     */
    public function getAll(): string;
}
