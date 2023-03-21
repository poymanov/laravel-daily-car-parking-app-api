<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Parking>
 */
class ParkingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'    => User::factory(),
            'vehicle_id' => Vehicle::factory(),
            'zone_id'    => Zone::factory(),
            'start_time' => now(),
        ];
    }
}
