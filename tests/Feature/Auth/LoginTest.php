<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/**
 * Попытка авторизации без указания данных
 */
test('empty', function () {
    $response = $this->postJson(routeBuilderHelper()->auth->login());

    $response->assertUnprocessable();

    $response->assertJsonStructure(['message', 'errors' => ['email', 'password']]);
});

/**
 * Попытка авторизации несуществующим пользователем
 */
test('not existed', function () {
    $response = $this->postJson(routeBuilderHelper()->auth->login(), [
        'email'    => faker()->email,
        'password' => faker()->password,
    ]);

    $response->assertBadRequest();

    $response->assertJsonFragment(['message' => 'The provided credentials are incorrect.']);
});

/**
 * Попытка авторизации с неправильным паролем
 */
test('wrong password', function () {
    $user = modelBuilderHelper()->user->create();

    $response = $this->postJson(routeBuilderHelper()->auth->login(), [
        'email'    => $user->email,
        'password' => faker()->password,
    ]);

    $response->assertBadRequest();

    $response->assertJsonFragment(['message' => 'The provided credentials are incorrect.']);
});

/**
 * Успешная попытка авторизации
 */
test('success', function () {
    $user = modelBuilderHelper()->user->create();

    $response = $this->postJson(routeBuilderHelper()->auth->login(), [
        'email'    => $user->email,
        'password' => 'password',
    ]);

    $response->assertCreated();

    $response->assertJsonStructure(['access_token']);

    $this->assertDatabaseHas(
        'personal_access_tokens',
        [
            'tokenable_type' => User::class,
            'tokenable_id'   => $user->id,
        ]
    );

    $this->assertDatabaseMissing(
        'personal_access_tokens',
        [
            'tokenable_type' => User::class,
            'tokenable_id'   => $user->id,
            'expires_at'     => null,
        ]
    );
});

/**
 * Успешная попытка авторизации с функционалом "Запомнить меня"
 */
test('success with remember', function () {
    $user = modelBuilderHelper()->user->create();

    $response = $this->postJson(routeBuilderHelper()->auth->login(), [
        'email'    => $user->email,
        'password' => 'password',
        'remember' => true,
    ]);

    $response->assertCreated();

    $response->assertJsonStructure(['access_token']);

    $this->assertDatabaseHas(
        'personal_access_tokens',
        [
            'tokenable_type' => User::class,
            'tokenable_id'   => $user->id,
            'expires_at'     => null,
        ]
    );
});
