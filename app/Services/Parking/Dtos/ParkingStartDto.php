<?php

namespace App\Services\Parking\Dtos;

use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ParkingStartDto
{
    public Uuid $vehicleId;

    public Uuid $zoneId;
}
