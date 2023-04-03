<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/**
 * Попытка добавления гостем
 */
test('guest', function () {
    $response = $this->postJson(routeBuilderHelper()->vehicle->store());

    $response->assertForbidden();

    $response->assertJsonFragment(['message' => 'Unauthenticated.']);
});

/**
 * Попытка создания без указания данных
 */
test('empty', function () {
    Sanctum::actingAs(modelBuilderHelper()->user->create());

    $response = $this->postJson(routeBuilderHelper()->vehicle->store());

    $response->assertUnprocessable();

    $response->assertJsonStructure(['message', 'errors' => ['plate_number']]);
});

/**
 * Попытка создания с уже существующим номером
 */
test('plate number already exists', function () {
    $user = modelBuilderHelper()->user->create();

    $vehicle = modelBuilderHelper()->vehicle->create(['user_id' => $user->id]);

    Sanctum::actingAs($user);

    $response = $this->postJson(routeBuilderHelper()->vehicle->store(), [
        'plate_number' => $vehicle->plate_number,
    ]);

    $response->assertUnprocessable();

    $response->assertJsonStructure(['message', 'errors' => ['plate_number']]);
});

/**
 * Успешное создание
 */
test('success', function () {
    $user = modelBuilderHelper()->user->create();

    $plateNumber = faker()->word;
    $description = faker()->word();

    Sanctum::actingAs($user);

    $response = $this->postJson(routeBuilderHelper()->vehicle->store(), [
        'plate_number' => $plateNumber,
        'description'  => $description,
    ]);

    $response->assertOk();

    $response->assertJsonFragment(['user_id' => $user->id, 'plate_number' => $plateNumber]);

    $this->assertDatabaseHas('vehicles', [
        'user_id'      => $user->id,
        'plate_number' => $plateNumber,
        'description'  => $description,
    ]);
});
