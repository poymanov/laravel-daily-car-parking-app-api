<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

/**
 * Попытка получения завершенных парковок гостем
 */
test('guest', function () {
    $response = $this->getJson(routeBuilderHelper()->parking->stopped());

    $response->assertForbidden();

    $response->assertJsonFragment(['message' => 'Unauthenticated.']);
});

/**
 * Парковки других пользователей не должны входить в список
 */
test('another user', function () {
    $user = modelBuilderHelper()->user->create();

    modelBuilderHelper()->parking->create();

    Sanctum::actingAs($user);

    $response = $this->getJson(routeBuilderHelper()->parking->stopped());

    $response->assertOk();

    $response->assertJson([]);
});

/**
 * Активные парковки не должны входить в список
 */
test('active', function () {
    $user = modelBuilderHelper()->user->create();

    modelBuilderHelper()->parking->create(['user_id' => $user->id]);

    Sanctum::actingAs($user);

    $response = $this->getJson(routeBuilderHelper()->parking->stopped());

    $response->assertOk();

    $response->assertJson([]);
});

/**
 * Успешное получение списка завершенных парковок
 */
test('success', function () {
    $user = modelBuilderHelper()->user->create();

    $parking = modelBuilderHelper()->parking->create(['user_id' => $user->id, 'stop_time' => now()->addHour(), 'total_price' => 100]);

    Sanctum::actingAs($user);

    $response = $this->getJson(routeBuilderHelper()->parking->stopped());

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
 * Успешное получение списка завершенных парковок,
 * с сортировкой по дате завершения парковки (более поздние - первые)
 */
test('success latest', function () {
    $user = modelBuilderHelper()->user->create();

    $parkingFirst = modelBuilderHelper()->parking->create(['user_id' => $user->id, 'stop_time' => now()->subHour()]);
    $parkingSecond = modelBuilderHelper()->parking->create(['user_id' => $user->id, 'stop_time' => now()->subHours(2)]);

    Sanctum::actingAs($user);

    $response = $this->getJson(routeBuilderHelper()->parking->stopped());

    $response->assertOk();

    $parkingIds = array_map(fn ($parkingItem) => $parkingItem['id'], $response->json());

    $this->assertEquals([$parkingFirst->id, $parkingSecond->id], $parkingIds);
});
