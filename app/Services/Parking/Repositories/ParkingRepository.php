<?php

namespace App\Services\Parking\Repositories;

use App\Models\Parking;
use App\Services\Parking\Contracts\ParkingDtoFactoryContract;
use App\Services\Parking\Contracts\ParkingRepositoryContract;
use App\Services\Parking\Dtos\ParkingDto;
use App\Services\Parking\Dtos\ParkingStartDto;
use App\Services\Parking\Exceptions\ParkingUpdateTotalPriceFailedException;
use App\Services\Parking\Exceptions\StartParkingFailedException;
use App\Services\Parking\Exceptions\ParkingNotFoundByIdException;
use App\Services\Parking\Exceptions\StopParkingFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ParkingRepository implements ParkingRepositoryContract
{
    public function __construct(private readonly ParkingDtoFactoryContract $parkingDtoFactory)
    {
    }


    /**
     * @inheritDoc
     */
    public function isStarted(Uuid $vehicleId, Uuid $zoneId): bool
    {
        return Parking::whereVehicleId($vehicleId->value())->whereZoneId($zoneId->value())->exists();
    }

    /**
     * @inheritDoc
     */
    public function start(int $userId, ParkingStartDto $parkingStartDto): void
    {
        $parking             = new Parking();
        $parking->user_id    = $userId;
        $parking->vehicle_id = $parkingStartDto->vehicleId->value();
        $parking->zone_id    = $parkingStartDto->zoneId->value();
        $parking->start_time = now();

        if (!$parking->save()) {
            throw new StartParkingFailedException();
        }
    }

    /**
     * @inheritDoc
     */
    public function isExistsById(Uuid $id): bool
    {
        return Parking::whereId($id->value())->exists();
    }

    /**
     * @inheritDoc
     */
    public function isBelongsToUser(Uuid $id, int $userId): bool
    {
        return Parking::whereId($id->value())->whereUserId($userId)->exists();
    }

    /**
     * @inheritDoc
     */
    public function isStopped(Uuid $id): bool
    {
        return Parking::whereId($id)
            ->whereNotNull('start_time')
            ->whereNotNull('stop_time')
            ->exists();
    }

    /**
     * @inheritDoc
     */
    public function stop(Uuid $id): void
    {
        $parking = $this->getOneModelById($id);
        $parking->stop_time = now();

        if (!$parking->save()) {
            throw new StopParkingFailedException($id);
        }
    }

    /**
     * @inheritDoc
     */
    public function getOneById(Uuid $id): ParkingDto
    {
        $parking = $this->getOneModelById($id);

        return $this->parkingDtoFactory->createFromModel($parking);
    }

    /**
     * @inheritDoc
     */
    public function updateTotalPrice(Uuid $id, int $totalPrice): void
    {
        $parking = $this->getOneModelById($id);
        $parking->total_price = $totalPrice;

        if (!$parking->save()) {
            throw new ParkingUpdateTotalPriceFailedException($id);
        }
    }

    /**
     * @inheritDoc
     */
    public function findAllActive(): array
    {
        $parkings = Parking::whereNotNull('start_time')->whereNull('stop_time')->get();

        return $this->parkingDtoFactory->createFromModels($parkings);
    }

    /**
     * @inheritDoc
     */
    public function findAllActiveByUserId(int $userId): array
    {
        $parkings = Parking::whereNotNull('start_time')
            ->whereNull('stop_time')
            ->whereUserId($userId)
            ->latest('start_time')
            ->get();

        return $this->parkingDtoFactory->createFromModels($parkings);
    }

    /**
     * @param Uuid $id
     *
     * @return Parking
     * @throws ParkingNotFoundByIdException
     */
    private function getOneModelById(Uuid $id): Parking
    {
        $parking = Parking::find($id->value());

        if (is_null($parking)) {
            throw new ParkingNotFoundByIdException($id);
        }

        return $parking;
    }
}
