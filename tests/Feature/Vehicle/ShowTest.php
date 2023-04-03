<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/**
 * Попытка получения гостем
 */
test('guest', function () {
    $vehicle = modelBuilderHelper()->vehicle->create();

    $response = $this->getJson(routeBuilderHelper()->vehicle->show($vehicle->id));

    $response->assertForbidden();

    $response->assertJsonFragment(['message' => 'Unauthenticated.']);
});

/**
 * Попытка получения несуществующего транспортного средства
 */
test('not existed', function () {
    Sanctum::actingAs(modelBuilderHelper()->user->create());

    $response = $this->getJson(routeBuilderHelper()->vehicle->show(faker()->uuid));

    $response->assertNotFound();

    $response->assertJsonStructure([]);
});

/**
 * Попытка получения транспортного средства, которое не принадлежит пользователю
 */
test('not belongs to user', function () {
    $vehicle = modelBuilderHelper()->vehicle->create();

    Sanctum::actingAs(modelBuilderHelper()->user->create());

    $response = $this->getJson(routeBuilderHelper()->vehicle->show($vehicle->id));

    $response->assertForbidden();

    $response->assertJsonStructure([]);
});

/**
 * Успешное получение транспортного средства
 */
test('success', function () {
    $user = modelBuilderHelper()->user->create();

    $vehicle = modelBuilderHelper()->vehicle->create(['user_id' => $user->id]);

    Sanctum::actingAs($user);

    $response = $this->getJson(routeBuilderHelper()->vehicle->show($vehicle->id));

    $response->assertOk();

    $response->assertJsonFragment([
        'id'           => $vehicle->id,
        'user_id'      => $user->id,
        'plate_number' => $vehicle->plate_number,
        'description' => $vehicle->description
    ]);
});
