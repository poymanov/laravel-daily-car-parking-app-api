<?php

namespace App\Services\Parking\Dtos;

use App\Services\Vehicle\Dtos\VehicleDto;
use App\Services\Zone\Dtos\ZoneDto;
use Carbon\Carbon;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ParkingDto
{
    public Uuid $id;

    public ZoneDto $zone;

    public VehicleDto $vehicle;

    public Carbon $startTime;

    public ?Carbon $stopTime;

    public int $userId;

    public int $totalPrice;
}
