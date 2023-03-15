<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

/**
 * Попытка получения гостем
 */
test('guest', function () {
    $response = $this->getJson(routeBuilderHelper()->vehicle->index());

    $response->assertForbidden();

    $response->assertJsonFragment(['message' => 'Unauthenticated.']);
});

/**
 * Если нет транспортных средств
 */
test('empty', function () {
    Sanctum::actingAs(modelBuilderHelper()->user->create());

    $response = $this->getJson(routeBuilderHelper()->vehicle->index());

    $response->assertOk();

    $response->assertJsonStructure([]);
});

/**
 * Транспортные средства других пользователей должны отсутствовать
 */
test('another user vehicles', function () {
    Sanctum::actingAs(modelBuilderHelper()->user->create());

    modelBuilderHelper()->vehicle->create();

    $response = $this->getJson(routeBuilderHelper()->vehicle->index());

    $response->assertOk();

    $response->assertJsonStructure([]);
});

/**
 * Успешное получение списка транспортных средств
 */
test('success', function () {
    $user = modelBuilderHelper()->user->create();

    Sanctum::actingAs($user);

    $vehicle = modelBuilderHelper()->vehicle->create(['user_id' => $user->id]);

    $response = $this->getJson(routeBuilderHelper()->vehicle->index());

    $response->assertOk();

    $response->assertJsonFragment([
        [
            'id'           => $vehicle->id,
            'user_id'      => $user->id,
            'plate_number' => $vehicle->plate_number,
        ],
    ]);
});

/**
 * Успешное получение списка с транспортными средствами с сортировкой по дате создания (новые - первые)
 */
test('success latest', function () {
    $user = modelBuilderHelper()->user->create();

    Sanctum::actingAs($user);

    $vehicleFirst  = modelBuilderHelper()->vehicle->create(['user_id' => $user->id]);

    $this->travel(1)->hour();

    $vehicleSecond = modelBuilderHelper()->vehicle->create(['user_id' => $user->id]);

    $response = $this->getJson(routeBuilderHelper()->vehicle->index());

    $response->assertOk();

    $response->assertJson([
        [
            'id'           => $vehicleSecond->id,
            'user_id'      => $user->id,
            'plate_number' => $vehicleSecond->plate_number,
        ],
        [
            'id'           => $vehicleFirst->id,
            'user_id'      => $user->id,
            'plate_number' => $vehicleFirst->plate_number,
        ],
    ]);
});
