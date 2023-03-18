<?php

namespace App\Services\Vehicle\Contracts;

use App\Services\Vehicle\Dtos\VehicleDto;
use App\Services\Vehicle\Dtos\VehicleUpdateDto;
use App\Services\Vehicle\Exceptions\DeleteVehicleFailedException;
use App\Services\Vehicle\Exceptions\UpdateVehicleFailedException;
use App\Services\Vehicle\Exceptions\VehicleNotBelongsToUserException;
use App\Services\Vehicle\Exceptions\VehicleNotFoundByIdException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface VehicleUserServiceContract
{
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
    public function update(Uuid $id, int $userId, VehicleUpdateDto $vehicleUpdateDto): void;

    /**
     * @param Uuid $id
     * @param int  $userId
     *
     * @return void
     * @throws VehicleNotBelongsToUserException
     * @throws DeleteVehicleFailedException
     * @throws VehicleNotFoundByIdException
     */
    public function delete(Uuid $id, int $userId): void;

    /**
     * @param Uuid $id
     * @param int  $userId
     *
     * @return VehicleDto
     * @throws VehicleNotBelongsToUserException
     */
    public function getOneById(Uuid $id, int $userId): VehicleDto;
}
