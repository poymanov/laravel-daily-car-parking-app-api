<?php

namespace App\Services\Vehicle\Contracts;

use App\Services\Vehicle\Dtos\VehicleDto;
use Closure;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

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
    public function rememberAndGetAllByUserId(int $userId, Closure $closure): array;

    /**
     * @param Uuid    $id
     * @param Closure $closure
     *
     * @return VehicleDto
     */
    public function rememberAndGetOneById(Uuid $id, Closure $closure): VehicleDto;
}
