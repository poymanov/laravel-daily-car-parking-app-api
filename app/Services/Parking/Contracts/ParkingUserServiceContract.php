<?php

namespace App\Services\Parking\Contracts;

use App\Services\Parking\Dtos\ParkingDto;
use App\Services\Parking\Exceptions\ParkingNotBelongsToUserException;
use App\Services\Parking\Exceptions\ParkingNotFoundByIdException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ParkingUserServiceContract
{
    /**
     * @param Uuid $id
     * @param int  $userId
     *
     * @return ParkingDto
     * @throws ParkingNotBelongsToUserException
     * @throws ParkingNotFoundByIdException
     */
    public function getOneById(Uuid $id, int $userId): ParkingDto;

    /**
     * @param Uuid $id
     * @param int  $userId
     *
     * @return void
     * @throws ParkingNotBelongsToUserException
     * @throws ParkingNotFoundByIdException
     * @throws \App\Services\Parking\Exceptions\ParkingAlreadyStoppedException
     * @throws \App\Services\Parking\Exceptions\StopParkingFailedException
     */
    public function stop(Uuid $id, int $userId): void;
}
