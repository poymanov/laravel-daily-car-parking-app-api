<?php

namespace App\Services\Parking\Services;

use App\Services\Parking\Contracts\ParkingCalculationServiceContract;
use App\Services\Parking\Contracts\ParkingRepositoryContract;
use Carbon\Carbon;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ParkingCalculationService implements ParkingCalculationServiceContract
{
    public function __construct(
        private readonly ParkingRepositoryContract $parkingRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function calculateTotalPrice(Uuid $id): void
    {
        $parking = $this->parkingRepository->getOneById($id);

        $parkingStart = $parking->startTime;
        $parkingStop  = $parking->stopTime ?? Carbon::now();

        $totalTimeByMinutes = $parkingStop->diffInMinutes($parkingStart);

        $priceByMinutes = $parking->zone->pricePerHour / 60;

        $totalPrice = intval(ceil($totalTimeByMinutes * $priceByMinutes));

        $this->parkingRepository->updateTotalPrice($id, $totalPrice);
    }
}
