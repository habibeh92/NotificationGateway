<?php

namespace Database\Factories;

use App\Models\User;
use App\NotificationDrivers\GhasedakDriver;
use App\NotificationDrivers\KavenegarDriver;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'message'  => fake()->text(30),
            'driver'   => fake()->boolean() ? KavenegarDriver::index() : GhasedakDriver::index(),
            'receptor' => "09" . fake()->randomNumber(9, true),
        ];
    }
}
