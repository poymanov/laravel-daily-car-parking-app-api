<?php

namespace App\Services\Vehicle\Repositories;

use App\Models\Vehicle;
use App\Services\Vehicle\Contracts\VehicleDtoFactoryContract;
use App\Services\Vehicle\Contracts\VehicleRepositoryContract;
use App\Services\Vehicle\Dtos\VehicleCreateDto;
use App\Services\Vehicle\Dtos\VehicleDto;
use App\Services\Vehicle\Dtos\VehicleUpdateDto;
use App\Services\Vehicle\Exceptions\CreateVehicleFailedException;
use App\Services\Vehicle\Exceptions\DeleteVehicleFailedException;
use App\Services\Vehicle\Exceptions\UpdateVehicleFailedException;
use App\Services\Vehicle\Exceptions\VehicleNotFoundByIdException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class VehicleRepository implements VehicleRepositoryContract
{
    public function __construct(private readonly VehicleDtoFactoryContract $vehicleDtoFactory)
    {
    }

    /**
     * @inheritDoc
     */
    public function create(int $userId, VehicleCreateDto $vehicleCreateDto): Uuid
    {
        $vehicle               = new Vehicle();
        $vehicle->user_id      = $userId;
        $vehicle->plate_number = $vehicleCreateDto->plateNumber;
        $vehicle->description  = $vehicleCreateDto->description;

        if (!$vehicle->save()) {
            throw new CreateVehicleFailedException();
        }

        return Uuid::make($vehicle->id);
    }

    /**
     * @inheritDoc
     */
    public function update(Uuid $id, VehicleUpdateDto $vehicleUpdateDto): void
    {
        $vehicle               = $this->getOneModelById($id);
        $vehicle->plate_number = $vehicleUpdateDto->plateNumber;
        $vehicle->description  = $vehicleUpdateDto->description;

        if (!$vehicle->save()) {
            throw new UpdateVehicleFailedException($id);
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(Uuid $id): void
    {
        $vehicle = $this->getOneModelById($id);

        if (!$vehicle->delete()) {
            throw new DeleteVehicleFailedException($id);
        }
    }

    /**
     * @inheritDoc
     */
    public function findAllByUserId(int $userId): array
    {
        $vehicles = Vehicle::whereUserId($userId)->latest()->get();

        return $this->vehicleDtoFactory->createFromModels($vehicles);
    }

    /**
     * @inheritDoc
     */
    public function getOneById(Uuid $id): VehicleDto
    {
        $vehicle = $this->getOneModelById($id);

        return $this->vehicleDtoFactory->createFromModel($vehicle);
    }

    /**
     * @inheritDoc
     */
    public function isBelongsToUser(Uuid $id, int $userId): bool
    {
        return Vehicle::whereId($id->value())->whereUserId($userId)->exists();
    }

    /**
     * @param Uuid $id
     *
     * @return Vehicle
     * @throws VehicleNotFoundByIdException
     */
    private function getOneModelById(Uuid $id): Vehicle
    {
        $vehicle = Vehicle::find($id->value());

        if (is_null($vehicle)) {
            throw new VehicleNotFoundByIdException($id);
        }

        return $vehicle;
    }
}
