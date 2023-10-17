<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title" => $this->faker->name,
            "description" => $this->faker->text,
            "time_start" => $this->faker->time,
            "time_end" => $this->faker->time,
            "user_id" => 1,
            "remind" => $this->faker->numberBetween(0, 1),
        ];
    }
}
