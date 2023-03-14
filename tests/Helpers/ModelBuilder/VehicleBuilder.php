<?php

namespace Tests\Helpers\ModelBuilder;

use App\Models\Vehicle;

class VehicleBuilder
{
    /**
     * Создание сущности {@see Vehicle}
     *
     * @param array $params Параметры нового объекта
     *
     * @return Vehicle
     */
    public function create(array $params = []): Vehicle
    {
        return Vehicle::factory()->createOne($params);
    }
}
