<?php

namespace App\Services\Vehicle\Contracts;

use App\Services\Vehicle\Dtos\VehicleDto;
use App\Services\Vehicle\Dtos\VehicleUpdateDto;
use App\Services\Vehicle\Exceptions\CreateVehicleFailedException;
use App\Services\Vehicle\Exceptions\DeleteVehicleFailedException;
use App\Services\Vehicle\Exceptions\UpdateVehicleFailedException;
use App\Services\Vehicle\Exceptions\VehicleNotFoundByIdException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface VehicleServiceContract
{
    /**
     * @param int    $userId
     * @param string $plateNumber
     *
     * @return Uuid
     * @throws CreateVehicleFailedException
     */
    public function create(int $userId, string $plateNumber): Uuid;

    /**
     * @param Uuid             $id
     * @param VehicleUpdateDto $vehicleUpdateDto
     *
     * @return void
     * @throws UpdateVehicleFailedException
     * @throws VehicleNotFoundByIdException
     */
    public function update(Uuid $id, VehicleUpdateDto $vehicleUpdateDto): void;

    /**
     * @param Uuid $id
     *
     * @return VehicleDto
     */
    public function getOneById(Uuid $id): VehicleDto;

    /**
     * @param int $userId
     *
     * @return array
     */
    public function findAllByUserId(int $userId): array;

    /**
     * @param Uuid $id
     *
     * @return void
     * @throws DeleteVehicleFailedException
     * @throws VehicleNotFoundByIdException
     */
    public function delete(Uuid $id): void;

    /**
     * @param Uuid $id
     * @param int  $userId
     *
     * @return bool
     */
    public function isBelongsToUser(Uuid $id, int $userId): bool;
}
