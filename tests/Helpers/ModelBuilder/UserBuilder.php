<?php

namespace Tests\Helpers\ModelBuilder;

use App\Models\User;

class UserBuilder
{
    /**
     * Создание сущности {@see User}
     *
     * @param array $params Параметры нового объекта
     *
     * @return User
     */
    public function create(array $params = []): User
    {
        return User::factory()->createOneQuietly($params);
    }
}
