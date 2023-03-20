<?php

namespace Tests\Helpers\ModelBuilder;

use App\Models\Zone;

class ZoneBuilder
{
    /**
     * Создание сущности {@see Zone}
     *
     * @param array $params Параметры нового объекта
     *
     * @return Zone
     */
    public function create(array $params = []): Zone
    {
        return Zone::factory()->createOne($params);
    }
}
