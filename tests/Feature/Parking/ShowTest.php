<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/**
 * Попытка просмотра гостем
 */
test('guest', function () {
    $response = $this->getJson(routeBuilderHelper()->parking->show(faker()->uuid));

    $response->assertForbidden();

    $response->assertJsonFragment(['message' => 'Unauthenticated.']);
});

/**
 * Попытка просмотра с неправильным ID
 */
test('wrong id', function () {
    Sanctum::actingAs(modelBuilderHelper()->user->create());

    $response = $this->getJson(routeBuilderHelper()->parking->show('123'));

    $response->assertUnprocessable();

    $response->assertJsonFragment(['message' => 'UUID is invalid.']);
});

/**
 * Попытка просмотра несуществующей парковки
 */
test('not exists', function () {
    Sanctum::actingAs(modelBuilderHelper()->user->create());

    $id = faker()->uuid;

    $response = $this->getJson(routeBuilderHelper()->parking->show($id));

    $response->assertNotFound();

    $response->assertJsonFragment(['message' => 'Parking not found by id: ' . $id]);
});

/**
 * Попытка просмотра парковки, не принадлежащего пользователю
 */
test('another user', function () {
    $user = modelBuilderHelper()->user->create();

    $parking = modelBuilderHelper()->parking->create();

    Sanctum::actingAs($user);

    $response = $this->getJson(routeBuilderHelper()->parking->show($parking->id));

    $response->assertBadRequest();

    $response->assertJsonFragment(['message' => 'Parking ' . $parking->id . ' not belongs to user.']);
});

/**
 * Успешный просмотр парковки
 */
test('success', function () {
    $user = modelBuilderHelper()->user->create();

    $parking = modelBuilderHelper()->parking->create(['user_id' => $user->id]);

    Sanctum::actingAs($user);

    $response = $this->getJson(routeBuilderHelper()->parking->show($parking->id));

    $response->assertOk();

    $response->assertJson([
        'id'          => $parking->id,
        'zone'        => [
            'name'           => $parking->zone->name,
            'price_per_hour' => $parking->zone->price_per_hour,
        ],
        'vehicle'     => [
            'plate_number' => $parking->vehicle->plate_number,
        ],
        'start_time'  => $parking->start_time->toDateTimeString(),
        'stop_time'   => $parking->stop_time?->toDateTimeString(),
        'total_price' => $parking->total_price,
    ]);
});
