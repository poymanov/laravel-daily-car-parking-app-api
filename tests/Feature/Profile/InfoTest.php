<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

/**
 * Попытка завершения сеанса гостем
 */
test('guest', function () {
    $response = $this->getJson(routeBuilderHelper()->profile->show());

    $response->assertForbidden();

    $response->assertJsonFragment(['message' => 'Unauthenticated.']);
});

/**
 * Попытка завершения сеанса гостем
 */
test('success', function () {
    $user = modelBuilderHelper()->user->create();

    Sanctum::actingAs($user);

    $response = $this->getJson(routeBuilderHelper()->profile->show());

    $response->assertOk();

    $response->assertJsonFragment(['id' => $user->id, 'name' => $user->name, 'email' => $user->email]);
});
