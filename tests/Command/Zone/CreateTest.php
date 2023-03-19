<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Psy\Command\ExitCommand;
use Tests\TestCase;

use function Pest\Faker\faker;

uses(TestCase::class, RefreshDatabase::class);

/** Выполнение команды без указания аргументов */
test('without arguments', function () {
    $this->expectException(RuntimeException::class);
    $this->expectExceptionMessage('Not enough arguments (missing: "name, price_per_hour")');

    $this->artisan('zone:create')->assertExitCode(ExitCommand::FAILURE);
});

/** Выполнение команды без указания цены за час */
test('without name', function () {
    $this->expectException(RuntimeException::class);
    $this->expectExceptionMessage('Not enough arguments (missing: "price_per_hour")');

    $this->artisan('zone:create ' . faker()->word)->assertExitCode(ExitCommand::FAILURE);
});

/** Успешное выполнение команды */
test('success', function () {
    $name         = faker()->word;
    $pricePerHour = faker()->numberBetween();

    $this->artisan('zone:create ' . $name . ' ' . $pricePerHour)
        ->expectsOutput('Success')
        ->assertExitCode(ExitCommand::SUCCESS);

    $this->assertDatabaseHas('zones', [
        'name'           => $name,
        'price_per_hour' => $pricePerHour,
    ]);
});
