<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/**
 * Попытка начала парковки гостем
 */
test('guest', function () {
    $response = $this->postJson(routeBuilderHelper()->parking->start());

    $response->assertForbidden();

    $response->assertJsonFragment(['message' => 'Unauthenticated.']);
});

/**
 * Попытка начала парковки без данных
 */
test('empty', function () {
    Sanctum::actingAs(modelBuilderHelper()->user->create());

    $response = $this->postJson(routeBuilderHelper()->parking->start());

    $response->assertUnprocessable();

    $response->assertJsonStructure(['message', 'errors' => ['vehicle_id', 'zone_id']]);
});

/**
 * Попытка начала парковки с неправильным ID транспортного средства
 */
test('wrong vehicle id', function () {
    $user = modelBuilderHelper()->user->create();

    Sanctum::actingAs($user);

    $response = $this->postJson(routeBuilderHelper()->parking->start(), [
        'vehicle_id' => 1,
    ]);

    $response->assertUnprocessable();

    $response->assertJsonFragment(['vehicle_id' => ['The vehicle id field must be a valid UUID.']]);
});

/**
 * Попытка начала парковки с неправильным ID зоны парковки
 */
test('wrong zone id', function () {
    $user = modelBuilderHelper()->user->create();

    Sanctum::actingAs($user);

    $response = $this->postJson(routeBuilderHelper()->parking->start(), [
        'zone_id' => 1,
    ]);

    $response->assertUnprocessable();

    $response->assertJsonFragment(['zone_id' => ['The zone id field must be a valid UUID.']]);
});

/**
 * Попытка начала парковки с несуществующим ID транспортного средства
 */
test('not exists vehicle id', function () {
    $user = modelBuilderHelper()->user->create();

    Sanctum::actingAs($user);

    $response = $this->postJson(routeBuilderHelper()->parking->start(), [
        'vehicle_id' => faker()->uuid,
    ]);

    $response->assertUnprocessable();

    $response->assertJsonFragment(['vehicle_id' => ['The selected vehicle id is invalid.']]);
});

/**
 * Попытка начала парковки с несуществующим ID зоны парковки
 */
test('not exists zone id', function () {
    $user = modelBuilderHelper()->user->create();

    Sanctum::actingAs($user);

    $response = $this->postJson(routeBuilderHelper()->parking->start(), [
        'zone_id' => faker()->uuid,
    ]);

    $response->assertUnprocessable();

    $response->assertJsonFragment(['zone_id' => ['The selected zone id is invalid.']]);
});

/**
 * Попытка начала парковки для транспортного средства, не принадлежащего пользователю
 */
test('another user vehicle', function () {
    $user = modelBuilderHelper()->user->create();

    $zone    = modelBuilderHelper()->zone->create();
    $vehicle = modelBuilderHelper()->vehicle->create();

    Sanctum::actingAs($user);

    $response = $this->postJson(routeBuilderHelper()->parking->start(), [
        'vehicle_id' => $vehicle->id,
        'zone_id'    => $zone->id,
    ]);

    $response->assertBadRequest();

    $response->assertJsonFragment(['message' => 'Vehicle ' . $vehicle->id . ' not belongs to user.']);
});


/**
 * Попытка начала парковки для транспортного средства, для которого уже запущена парковка
 */
test('already start', function () {
    $user    = modelBuilderHelper()->user->create();
    $zone    = modelBuilderHelper()->zone->create();
    $vehicle = modelBuilderHelper()->vehicle->create(['user_id' => $user->id]);

    modelBuilderHelper()->parking->create(
        ['user_id' => $user->id, 'vehicle_id' => $vehicle->id, 'zone_id' => $zone->id]
    );

    Sanctum::actingAs($user);

    $response = $this->postJson(routeBuilderHelper()->parking->start(), [
        'vehicle_id' => $vehicle->id,
        'zone_id'    => $zone->id,
    ]);

    $response->assertBadRequest();

    $response->assertJsonFragment(['message' => 'Parking already started for vehicle ' . $vehicle->id . ' in zone ' . $zone->id . '.']);
});

/**
 * Успешный запуск парковки
 */
test('success', function () {
    $user    = modelBuilderHelper()->user->create();
    $zone    = modelBuilderHelper()->zone->create();
    $vehicle = modelBuilderHelper()->vehicle->create(['user_id' => $user->id]);

    Sanctum::actingAs($user);

    $response = $this->postJson(routeBuilderHelper()->parking->start(), [
        'vehicle_id' => $vehicle->id,
        'zone_id'    => $zone->id,
    ]);

    $response->assertNoContent();

    $this->assertDatabaseHas('parkings', [
        'user_id'    => $user->id,
        'vehicle_id' => $vehicle->id,
        'zone_id'    => $zone->id,
    ]);
});
