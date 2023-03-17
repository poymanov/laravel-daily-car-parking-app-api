<?php

namespace App\Services\Vehicle\Contracts;

use App\Services\Vehicle\Dtos\VehicleDto;
use App\Services\Vehicle\Dtos\VehicleUpdateDto;
use App\Services\Vehicle\Exceptions\CreateVehicleFailedException;
use App\Services\Vehicle\Exceptions\UpdateVehicleFailedException;
use App\Services\Vehicle\Exceptions\VehicleNotBelongsToUserException;
use App\Services\Vehicle\Exceptions\VehicleNotFoundByIdException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface VehicleServiceContract
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
     * @param Uuid             $id
     * @param int              $userId
     * @param VehicleUpdateDto $vehicleUpdateDto
     *
     * @return void
     * @throws VehicleNotBelongsToUserException
     * @throws UpdateVehicleFailedException
     * @throws VehicleNotFoundByIdException
     */
    public function updateByUserId(Uuid $id, int $userId, VehicleUpdateDto $vehicleUpdateDto): void;

    /**
     * @param int $userId
     *
     * @return VehicleDto[]
     */
    public function findAllByUserId(int $userId): array;

    /**
     * @param Uuid $id
     * @param int  $userId
     *
     * @return VehicleDto
     * @throws VehicleNotBelongsToUserException
     * @throws VehicleNotFoundByIdException
     */
    public function getOneByIdAndUserId(Uuid $id, int $userId): VehicleDto;
}
