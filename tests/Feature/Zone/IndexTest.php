<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * Если нет зон
 */
test('empty', function () {
    $response = $this->getJson(routeBuilderHelper()->zone->index());

    $response->assertOk();

    $response->assertJsonStructure([]);
});

/**
 * Успешное получение списка зон
 */
test('success', function () {
    $zone = modelBuilderHelper()->zone->create();

    $response = $this->getJson(routeBuilderHelper()->zone->index());

    $response->assertOk();

    $response->assertJsonFragment([
        [
            'id'             => $zone->id,
            'name'           => $zone->name,
            'price_per_hour' => $zone->price_per_hour,
        ],
    ]);
});

/**
 * Успешное получение списка зон с сортировкой по дате создания (новые - первые)
 */
test('success latest', function () {
    $zoneFirst = modelBuilderHelper()->zone->create();

    $this->travel(1)->hour();

    $zoneSecond = modelBuilderHelper()->zone->create();

    $response = $this->getJson(routeBuilderHelper()->zone->index());

    $response->assertOk();

    $response->assertJson([
        [
            'id'             => $zoneSecond->id,
            'name'           => $zoneSecond->name,
            'price_per_hour' => $zoneSecond->price_per_hour,
        ],
        [
            'id'             => $zoneFirst->id,
            'name'           => $zoneFirst->name,
            'price_per_hour' => $zoneFirst->price_per_hour,
        ],
    ]);
});
