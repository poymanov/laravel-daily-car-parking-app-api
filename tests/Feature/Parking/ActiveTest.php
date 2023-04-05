<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

/**
 * Попытка получения активных парковок гостем
 */
test('guest', function () {
    $response = $this->getJson(routeBuilderHelper()->parking->active());

    $response->assertForbidden();

    $response->assertJsonFragment(['message' => 'Unauthenticated.']);
});

/**
 * Активные парковки других пользователей не должны входить в список
 */
test('another user', function () {
    $user = modelBuilderHelper()->user->create();

    modelBuilderHelper()->parking->create();

    Sanctum::actingAs($user);

    $response = $this->getJson(routeBuilderHelper()->parking->active());

    $response->assertOk();

    $response->assertJson([]);
});

/**
 * Завершенные парковки не должны входить в список
 */
test('stopped', function () {
    $user = modelBuilderHelper()->user->create();

    modelBuilderHelper()->parking->create(['user_id' => $user->id, 'stop_time' => now()->addHour()]);

    Sanctum::actingAs($user);

    $response = $this->getJson(routeBuilderHelper()->parking->active());

    $response->assertOk();

    $response->assertJson([]);
});

/**
 * Успешное получение списка активных парковок
 */
test('success', function () {
    $user = modelBuilderHelper()->user->create();

    $parking = modelBuilderHelper()->parking->create(['user_id' => $user->id]);

    Sanctum::actingAs($user);

    $response = $this->getJson(routeBuilderHelper()->parking->active());

    $response->assertOk();

    $response->assertJson([
        [
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
        ],
    ]);
});

/**
 * Успешное получение списка активных парковок,
 * с сортировкой по дате начала парковки (более поздние - первые)
 */
test('success latest', function () {
    $user = modelBuilderHelper()->user->create();

    $parkingFirst = modelBuilderHelper()->parking->create(['user_id' => $user->id]);
    $parkingSecond = modelBuilderHelper()->parking->create(['user_id' => $user->id, 'start_time' => now()->subHour()]);

    Sanctum::actingAs($user);

    $response = $this->getJson(routeBuilderHelper()->parking->active());

    $response->assertOk();

    $parkingIds = array_map(fn ($parkingItem) => $parkingItem['id'], $response->json());

    $this->assertEquals([$parkingFirst->id, $parkingSecond->id], $parkingIds);
});
