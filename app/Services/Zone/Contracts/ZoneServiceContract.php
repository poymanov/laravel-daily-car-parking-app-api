<?php

namespace App\Services\Zone\Contracts;

use App\Services\Zone\Dtos\CreateZoneDto;
use App\Services\Zone\Dtos\ZoneDto;
use App\Services\Zone\Exceptions\CreateZoneFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ZoneServiceContract
{
    /**
     * @param CreateZoneDto $createZoneDto
     *
     * @return Uuid
     * @throws CreateZoneFailedException
     */
    public function create(CreateZoneDto $createZoneDto): Uuid;

    /**
     * @return ZoneDto[]
     */
    public function findAll(): array;

    /**
     * @param Uuid $id
     *
     * @return bool
     */
    public function isExistsById(Uuid $id): bool;
}
