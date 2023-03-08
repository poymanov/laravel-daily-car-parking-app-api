<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/**
 * Попытка регистрации без указания данных
 */
test('empty', function () {
    $response = $this->postJson(routeBuilderHelper()->auth->register());

    $response->assertUnprocessable();

    $response->assertJsonStructure(['message', 'errors' => ['name', 'email', 'password']]);
});

/**
 * Попытка регистрации с email существующего пользователя
 */
test('already exists', function () {
    $user = modelBuilderHelper()->user->create();

    $password = faker()->password;

    $response = $this->postJson(routeBuilderHelper()->auth->register(), [
        'name'                  => $user->name,
        'email'                 => $user->email,
        'password'              => $password,
        'password_confirmation' => $password,
    ]);

    $response->assertUnprocessable();

    $response->assertJsonStructure(['message', 'errors' => ['email']]);
});

/**
 * Успешная регистрация
 */
test('success', function () {
    $name     = faker()->name;
    $email    = faker()->email;
    $password = faker()->password(8);

    $response = $this->postJson(routeBuilderHelper()->auth->register(), [
        'name'                  => $name,
        'email'                 => $email,
        'password'              => $password,
        'password_confirmation' => $password,
    ]);

    $response->assertCreated();

    $response->assertJsonStructure(['access_token']);

    $this->assertDatabaseHas('users', ['name' => $name, 'email' => $email]);
});
