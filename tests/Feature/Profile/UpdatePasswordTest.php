<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

/**
 * Попытка обновления гостем
 */
test('guest', function () {
    $response = $this->patchJson(routeBuilderHelper()->profile->updatePassword());

    $response->assertForbidden();

    $response->assertJsonFragment(['message' => 'Unauthenticated.']);
});

/**
 * Попытка обновления без указания данных
 */
test('empty', function () {
    Sanctum::actingAs(modelBuilderHelper()->user->create());

    $response = $this->patchJson(routeBuilderHelper()->profile->updatePassword());

    $response->assertUnprocessable();

    $response->assertJsonStructure(['message', 'errors' => ['current_password', 'password']]);
});

/**
 * Попытка обновления с неправильным текущим паролем
 */
test('wrong current password', function () {
    Sanctum::actingAs(modelBuilderHelper()->user->create());

    $response = $this->patchJson(routeBuilderHelper()->profile->updatePassword(), [
        'current_password'      => '123',
        'password'              => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertUnprocessable();

    $response->assertJsonStructure(['message', 'errors' => ['current_password']]);
});

/**
 * Попытка обновления с неправильным текущим паролем
 */
test('without password confirmation', function () {
    Sanctum::actingAs(modelBuilderHelper()->user->create());

    $response = $this->patchJson(routeBuilderHelper()->profile->updatePassword(), [
        'current_password' => 'password',
        'password'         => 'password123',
    ]);

    $response->assertUnprocessable();

    $response->assertJsonStructure(['message', 'errors' => ['password']]);
});

/**
 * Попытка обновления с неправильным новым паролем
 */
test('wrong password', function () {
    Sanctum::actingAs(modelBuilderHelper()->user->create());

    $response = $this->patchJson(routeBuilderHelper()->profile->updatePassword(), [
        'current_password'      => 'password',
        'password'              => 'pass',
        'password_confirmation' => 'pass',
    ]);

    $response->assertUnprocessable();

    $response->assertJsonStructure(['message', 'errors' => ['password']]);
});

/**
 * Успешное обновление пароля
 */
test('success', function () {
    $user = modelBuilderHelper()->user->create();
    Sanctum::actingAs($user);

    $response = $this->patchJson(routeBuilderHelper()->profile->updatePassword(), [
        'current_password'      => 'password',
        'password'              => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertNoContent();

    $this->assertDatabaseMissing('users', [
        'id'       => $user->id,
        'password' => $user->password,
    ]);
});
