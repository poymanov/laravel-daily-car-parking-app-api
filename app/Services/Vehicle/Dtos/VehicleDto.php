<?php

namespace App\Services\Vehicle\Dtos;

use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class VehicleDto
{
    public Uuid $id;

    public int $userId;

    public string $plateNumber;
}
