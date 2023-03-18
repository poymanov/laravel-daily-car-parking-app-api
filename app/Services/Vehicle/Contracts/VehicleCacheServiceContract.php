<?php

namespace App\Services\Vehicle\Contracts;

use App\Services\Vehicle\Dtos\VehicleDto;
use Closure;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface VehicleCacheServiceContract
{
    /**
     * @return void
     */
    public function forgetAll(): void;

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
