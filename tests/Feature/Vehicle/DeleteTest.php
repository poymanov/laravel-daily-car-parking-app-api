<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/**
 * Попытка удаления гостем
 */
test('guest', function () {
    $vehicle = modelBuilderHelper()->vehicle->create();

    $response = $this->deleteJson(routeBuilderHelper()->vehicle->delete($vehicle->id));

    $response->assertForbidden();

    $response->assertJsonFragment(['message' => 'Unauthenticated.']);
});

/**
 * Попытка удаления несуществующего транспортного средства
 */
test('not existed', function () {
    Sanctum::actingAs(modelBuilderHelper()->user->create());

    $response = $this->deleteJson(routeBuilderHelper()->vehicle->delete(faker()->uuid));

    $response->assertNotFound();

    $response->assertJsonStructure([]);
});

/**
 * Попытка удаления транспортного средства, которое не принадлежит пользователю
 */
test('not belongs to user', function () {
    $vehicle = modelBuilderHelper()->vehicle->create();

    Sanctum::actingAs(modelBuilderHelper()->user->create());

    $response = $this->deleteJson(routeBuilderHelper()->vehicle->delete($vehicle->id));

    $response->assertForbidden();

    $response->assertJsonStructure([]);
});

/**
 * Успешное удаление
 */
test('success', function () {
    $user    = modelBuilderHelper()->user->create();
    $vehicle = modelBuilderHelper()->vehicle->create(['user_id' => $user->id]);

    Sanctum::actingAs($user);

    $response = $this->deleteJson(routeBuilderHelper()->vehicle->update($vehicle->id));

    $response->assertNoContent();

    $this->assertDatabaseMissing('vehicles', [
        'id'         => $vehicle->id,
        'user_id'    => $user->id,
        'deleted_at' => null,
    ]);
});
