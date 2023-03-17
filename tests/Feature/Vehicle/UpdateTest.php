<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/**
 * Попытка обновления гостем
 */
test('guest', function () {
    $vehicle = modelBuilderHelper()->vehicle->create();

    $response = $this->patchJson(routeBuilderHelper()->vehicle->update($vehicle->id));

    $response->assertForbidden();

    $response->assertJsonFragment(['message' => 'Unauthenticated.']);
});

/**
 * Попытка обновления без данных
 */
test('empty', function () {
    Sanctum::actingAs(modelBuilderHelper()->user->create());

    $vehicle = modelBuilderHelper()->vehicle->create();

    $response = $this->patchJson(routeBuilderHelper()->vehicle->update($vehicle->id));

    $response->assertUnprocessable();

    $response->assertJsonStructure(['message', 'errors' => ['plate_number']]);
});

/**
 * Попытка обновления с уже существующими данными
 */
test('already exists', function () {
    Sanctum::actingAs(modelBuilderHelper()->user->create());

    $vehicleExists = modelBuilderHelper()->vehicle->create();

    $vehicle = modelBuilderHelper()->vehicle->create();

    $response = $this->patchJson(routeBuilderHelper()->vehicle->update($vehicle->id), [
        'plate_number' => $vehicleExists->plate_number,
    ]);

    $response->assertUnprocessable();

    $response->assertJsonStructure(['message', 'errors' => ['plate_number']]);
    $response->assertJsonFragment(['plate_number' => ['The plate number has already been taken.']]);
});

/**
 * Попытка обновления несуществующего транспортного средства
 */
test('not existed', function () {
    Sanctum::actingAs(modelBuilderHelper()->user->create());

    $response = $this->patchJson(routeBuilderHelper()->vehicle->update(faker()->uuid), [
        'plate_number' => faker()->word,
    ]);

    $response->assertNotFound();

    $response->assertJsonStructure([]);
});

/**
 * Попытка обновления транспортного средства, которое не принадлежит пользователю
 */
test('not belongs to user', function () {
    $vehicle = modelBuilderHelper()->vehicle->create();

    Sanctum::actingAs(modelBuilderHelper()->user->create());

    $response = $this->patchJson(routeBuilderHelper()->vehicle->update($vehicle->id), [
        'plate_number' => faker()->word,
    ]);

    $response->assertForbidden();

    $response->assertJsonStructure([]);
});

/**
 * Успешное обновление
 */
test('success', function () {
    $user    = modelBuilderHelper()->user->create();
    $vehicle = modelBuilderHelper()->vehicle->create(['user_id' => $user->id]);

    $newPlateNumber = faker()->word;

    Sanctum::actingAs($user);

    $response = $this->patchJson(routeBuilderHelper()->vehicle->update($vehicle->id), [
        'plate_number' => $newPlateNumber,
    ]);

    $response->assertOk();

    $response->assertJsonFragment([
        'id'           => $vehicle->id,
        'user_id'      => $user->id,
        'plate_number' => $newPlateNumber,
    ]);

    $this->assertDatabaseHas('vehicles', [
        'id'           => $vehicle->id,
        'user_id'      => $user->id,
        'plate_number' => $newPlateNumber,
    ]);
});

/**
 * Успешное обновление с такими же данными
 */
test('success same data', function () {
    $user    = modelBuilderHelper()->user->create();
    $vehicle = modelBuilderHelper()->vehicle->create(['user_id' => $user->id]);

    $newPlateNumber = $vehicle->plate_number;

    Sanctum::actingAs($user);

    $response = $this->patchJson(routeBuilderHelper()->vehicle->update($vehicle->id), [
        'plate_number' => $newPlateNumber,
    ]);

    $response->assertOk();

    $response->assertJsonFragment([
        'id'           => $vehicle->id,
        'user_id'      => $user->id,
        'plate_number' => $newPlateNumber,
    ]);

    $this->assertDatabaseHas('vehicles', [
        'id'           => $vehicle->id,
        'user_id'      => $user->id,
        'plate_number' => $newPlateNumber,
    ]);
});
