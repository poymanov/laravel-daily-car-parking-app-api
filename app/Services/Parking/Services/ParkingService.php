<?php

namespace App\Services\Parking\Services;

use App\Services\Parking\Contracts\ParkingCacheServiceContract;
use App\Services\Parking\Contracts\ParkingCalculationServiceContract;
use App\Services\Parking\Contracts\ParkingRepositoryContract;
use App\Services\Parking\Contracts\ParkingServiceContract;
use App\Services\Parking\Dtos\ParkingDto;
use App\Services\Parking\Dtos\ParkingStartDto;
use App\Services\Parking\Exceptions\ParkingAlreadyStartedException;
use App\Services\Parking\Exceptions\ParkingAlreadyStoppedException;
use App\Services\Parking\Exceptions\ParkingNotFoundByIdException;
use App\Services\Parking\Exceptions\VehicleNotBelongsToUserException;
use App\Services\Parking\Exceptions\ZoneNotExistsException;
use App\Services\Vehicle\Contracts\VehicleServiceContract;
use App\Services\Zone\Contracts\ZoneServiceContract;
use Illuminate\Support\Facades\DB;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Throwable;

class ParkingService implements ParkingServiceContract
{
    public function __construct(
        private readonly ZoneServiceContract $zoneService,
        private readonly VehicleServiceContract $vehicleService,
        private readonly ParkingRepositoryContract $parkingRepository,
        private readonly ParkingCacheServiceContract $parkingCacheService,
        private readonly ParkingCalculationServiceContract $parkingCalculationService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function start(int $userId, ParkingStartDto $parkingStartDto): void
    {
        // Если зона не существует
        if (!$this->zoneService->isExistsById($parkingStartDto->zoneId)) {
            throw new ZoneNotExistsException($parkingStartDto->zoneId);
        }

        // Если транспортное средство не принадлежит пользователю
        if (!$this->vehicleService->isBelongsToUser($parkingStartDto->vehicleId, $userId)) {
            throw new VehicleNotBelongsToUserException($parkingStartDto->vehicleId);
        }

        // Если для транспортного средства уже запущена парковка
        if ($this->parkingRepository->isStarted($parkingStartDto->vehicleId, $parkingStartDto->zoneId)) {
            throw new ParkingAlreadyStartedException($parkingStartDto->vehicleId, $parkingStartDto->zoneId);
        }

        $this->parkingRepository->start($userId, $parkingStartDto);

        $this->parkingCacheService->forgetAll();
    }

    /**
     * @inheritDoc
     */
    public function stop(Uuid $id): void
    {
        // Если парковка не найдена
        if (!$this->parkingRepository->isExistsById($id)) {
            throw new ParkingNotFoundByIdException($id);
        }

        // Если парковка уже остановлена
        if ($this->parkingRepository->isStopped($id)) {
            throw new ParkingAlreadyStoppedException($id);
        }

        DB::beginTransaction();

        try {
            $this->parkingRepository->stop($id);

            $this->parkingCalculationService->calculateTotalPrice($id);

            $this->parkingCacheService->forgetAll();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollback();

            throw $e;
        }
    }

    /**
     * @inheritDoc
     */
    public function getOneById(Uuid $id): ParkingDto
    {
        // Если парковка не найдена
        if (!$this->parkingRepository->isExistsById($id)) {
            throw new ParkingNotFoundByIdException($id);
        }

        return $this->parkingCacheService->rememberAndGetOneById($id, function () use ($id) {
            return $this->parkingRepository->getOneById($id);
        });
    }
}
