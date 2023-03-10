<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

/**
 * Попытка завершения сеанса гостем
 */
test('guest', function () {
    $response = $this->postJson(routeBuilderHelper()->auth->logout());

    $response->assertBadRequest();

    $response->assertJsonFragment(['message' => 'Unauthenticated.']);
});

/**
 * Успешное завершение сеанса
 */
test('success', function () {
    $user = modelBuilderHelper()->user->create();

    Sanctum::actingAs($user);

    $response = $this->postJson(routeBuilderHelper()->auth->logout());

    $response->assertNoContent();

    $this->assertDatabaseMissing(
        'personal_access_tokens',
        [
            'tokenable_type' => User::class,
            'tokenable_id'   => $user->id,
        ]
    );
});
