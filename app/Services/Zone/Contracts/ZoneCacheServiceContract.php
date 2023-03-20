<?php

namespace App\Services\Zone\Contracts;

use Closure;

interface ZoneCacheServiceContract
{
    /**
     * @return void
     */
    public function forgetAll(): void;

    /**
     * @param Closure $closure
     *
     * @return array
     */
    public function rememberAndGetAll(Closure $closure): array;
}
