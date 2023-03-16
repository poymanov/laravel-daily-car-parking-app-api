<?php

namespace App\Services\Vehicle\Contracts;

use App\Services\Vehicle\Dtos\VehicleDto;
use App\Services\Vehicle\Exceptions\CreateVehicleFailedException;
use App\Services\Vehicle\Exceptions\VehicleNotFoundByIdException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface VehicleRepositoryContract
{
    /**
     * @param int    $userId
     * @param string $plateNumber
     *
     * @return VehicleDto
     * @throws CreateVehicleFailedException
     */
    public function create(int $userId, string $plateNumber): VehicleDto;

    /**
     * @param int $userId
     *
     * @return VehicleDto[]
     */
    public function findAllByUserId(int $userId): array;

    /**
     * @param Uuid $id
     *
     * @return VehicleDto
     * @throws VehicleNotFoundByIdException
     */
    public function getOneById(Uuid $id): VehicleDto;
}
