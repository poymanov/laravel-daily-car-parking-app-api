<?php

namespace App\Services\Zone\Dtos;

use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ZoneDto
{
    public Uuid $id;

    public string $name;

    public int $pricePerHour;
}
