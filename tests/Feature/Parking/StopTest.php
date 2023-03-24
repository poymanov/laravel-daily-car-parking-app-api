<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/**
 * Попытка остановки парковки гостем
 */
test('guest', function () {
    $response = $this->patchJson(routeBuilderHelper()->parking->stop(faker()->uuid));

    $response->assertForbidden();

    $response->assertJsonFragment(['message' => 'Unauthenticated.']);
});

/**
 * Попытка остановки парковки с неправильным ID
 */
test('wrong id', function () {
    Sanctum::actingAs(modelBuilderHelper()->user->create());

    $response = $this->patchJson(routeBuilderHelper()->parking->stop('123'));

    $response->assertUnprocessable();

    $response->assertJsonFragment(['message' => 'UUID is invalid.']);
});

/**
 * Попытка остановки несуществующей парковки
 */
test('not exists', function () {
    Sanctum::actingAs(modelBuilderHelper()->user->create());

    $id = faker()->uuid;

    $response = $this->patchJson(routeBuilderHelper()->parking->stop($id));

    $response->assertNotFound();

    $response->assertJsonFragment(['message' => 'Parking not found by id: ' . $id]);
});

/**
 * Попытка остановки парковки, не принадлежащего пользователю
 */
test('another user', function () {
    $user = modelBuilderHelper()->user->create();

    $parking = modelBuilderHelper()->parking->create();

    Sanctum::actingAs($user);

    $response = $this->patchJson(routeBuilderHelper()->parking->stop($parking->id));

    $response->assertBadRequest();

    $response->assertJsonFragment(['message' => 'Parking ' . $parking->id . ' not belongs to user.']);
});

/**
 * Попытка остановки парковки, которая уже остановлена
 */
test('already stop', function () {
    $user = modelBuilderHelper()->user->create();

    $parking = modelBuilderHelper()->parking->create(['user_id' => $user->id, 'start_time' => now()->subHour(), 'stop_time' => now()]);

    Sanctum::actingAs($user);

    $response = $this->patchJson(routeBuilderHelper()->parking->stop($parking->id));

    $response->assertBadRequest();

    $response->assertJsonFragment(['message' => 'Parking ' . $parking->id . ' already stopped.']);
});

/**
 * Успешная остановка парковки
 */
test('success', function () {
    $user = modelBuilderHelper()->user->create();

    $parking = modelBuilderHelper()->parking->create(['user_id' => $user->id, 'start_time' => now()]);

    Sanctum::actingAs($user);

    $response = $this->patchJson(routeBuilderHelper()->parking->stop($parking->id));

    $response->assertNoContent();

    $this->assertDatabaseMissing('parkings', [
        'id'        => $parking->id,
        'stop_time' => null,
    ]);
});

/**
 * Успешная остановка парковки и подсчет её итоговой стоимости
 */
test('success with calculation', function () {
    $user = modelBuilderHelper()->user->create();

    $parking = modelBuilderHelper()->parking->create(['user_id' => $user->id, 'start_time' => now()]);

    Sanctum::actingAs($user);

    $this->travel(1)->hour();

    $response = $this->patchJson(routeBuilderHelper()->parking->stop($parking->id));

    $response->assertNoContent();

    $this->assertDatabaseHas('parkings', [
        'id'          => $parking->id,
        'total_price' => $parking->zone->price_per_hour,
    ]);
});
