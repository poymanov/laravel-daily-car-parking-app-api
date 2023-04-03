<?php

namespace App\Services\Vehicle\Contracts;

use App\Services\Vehicle\Dtos\VehicleCreateDto;
use App\Services\Vehicle\Dtos\VehicleDto;
use App\Services\Vehicle\Dtos\VehicleUpdateDto;
use App\Services\Vehicle\Exceptions\CreateVehicleFailedException;
use App\Services\Vehicle\Exceptions\DeleteVehicleFailedException;
use App\Services\Vehicle\Exceptions\UpdateVehicleFailedException;
use App\Services\Vehicle\Exceptions\VehicleNotFoundByIdException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface VehicleRepositoryContract
{
    /**
     * @param int              $userId
     * @param VehicleCreateDto $vehicleCreateDto
     *
     * @return Uuid
     * @throws CreateVehicleFailedException
     */
    public function create(int $userId, VehicleCreateDto $vehicleCreateDto): Uuid;

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
     * @return void
     * @throws DeleteVehicleFailedException
     * @throws VehicleNotFoundByIdException
     */
    public function delete(Uuid $id): void;

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

    /**
     * @param Uuid $id
     * @param int  $userId
     *
     * @return bool
     */
    public function isBelongsToUser(Uuid $id, int $userId): bool;
}
