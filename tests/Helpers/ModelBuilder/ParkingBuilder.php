<?php

namespace Tests\Helpers\ModelBuilder;

use App\Models\Parking;

class ParkingBuilder
{
    /**
     * Создание сущности {@see Parking}
     *
     * @param array $params Параметры нового объекта
     *
     * @return Parking
     */
    public function create(array $params = []): Parking
    {
        return Parking::factory()->createOne($params);
    }
}
