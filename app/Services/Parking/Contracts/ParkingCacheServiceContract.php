<?php

namespace App\Services\Parking\Contracts;

use App\Services\Parking\Dtos\ParkingDto;
use Closure;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ParkingCacheServiceContract
{
    /**
     * @return void
     */
    public function forgetAll(): void;

    /**
     * @param Uuid    $id
     * @param Closure $closure
     *
     * @return ParkingDto
     */
    public function rememberAndGetOneById(Uuid $id, Closure $closure): ParkingDto;
}
