<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/**
 * Попытка обновления гостем
 */
test('guest', function () {
    $response = $this->patchJson(routeBuilderHelper()->profile->update());

    $response->assertForbidden();

    $response->assertJsonFragment(['message' => 'Unauthenticated.']);
});

/**
 * Попытка обновления email на уже существующий
 */
test('not unique email', function () {
    $user = modelBuilderHelper()->user->create();

    Sanctum::actingAs(modelBuilderHelper()->user->create());

    $response = $this->patchJson(
        routeBuilderHelper()->profile->update(),
        [
            'name'  => $user->name,
            'email' => $user->email,
        ]
    );

    $response->assertUnprocessable();

    $response->assertJsonStructure(['message', 'errors' => ['email']]);
});

/**
 * Успешное обновление данных
 */
test('success', function () {
    $user = modelBuilderHelper()->user->create();

    $newName  = faker()->name;
    $newEmail = faker()->email;

    Sanctum::actingAs($user);

    $response = $this->patchJson(
        routeBuilderHelper()->profile->update(),
        [
            'name'  => $newName,
            'email' => $newEmail,
        ]
    );

    $response->assertOk();

    $response->assertJsonFragment(['name' => $newName, 'email' => $newEmail]);

    $this->assertDatabaseHas('users', [
        'id'    => $user->id,
        'name'  => $newName,
        'email' => $newEmail,
    ]);
});

/**
 * Успешное обновление данных без их изменения (с такими же данными, как и было до этого)
 */
test('success with same', function () {
    $user = modelBuilderHelper()->user->create();

    $name  = $user->name;
    $email = $user->email;

    Sanctum::actingAs($user);

    $response = $this->patchJson(
        routeBuilderHelper()->profile->update(),
        [
            'name'  => $name,
            'email' => $email,
        ]
    );

    $response->assertOk();

    $response->assertJsonFragment(['name' => $name, 'email' => $email]);

    $this->assertDatabaseHas('users', [
        'id'    => $user->id,
        'name'  => $name,
        'email' => $email,
    ]);
});
