<?php

namespace App\Services\Vehicle\Contracts;

use App\Services\Vehicle\Dtos\VehicleDto;
use Closure;

interface VehicleCacheServiceContract
{
    /**
     * @param int $userId
     *
     * @return void
     */
    public function forgetAll(int $userId): void;

    /**
     * @param int     $userId
     * @param Closure $closure
     *
     * @return VehicleDto[]
     */
    public function rememberAndGetAll(int $userId, Closure $closure): array;
}
