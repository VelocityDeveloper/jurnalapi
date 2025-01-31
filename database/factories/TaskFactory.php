<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate tanggal dan waktu acak untuk 'start' dan 'end'
        $start = $this->faker->dateTimeBetween('-1 month', 'now'); // Tanggal mulai dalam 1 bulan terakhir
        $end = $this->faker->dateTimeBetween($start, '+1 month'); // Tanggal selesai setelah 'start'

        return [
            'title'         => $this->faker->sentence(),
            'description'   => $this->faker->paragraph(),
            'start'         => $start,
            'end'           => $end,
            'status'        => $this->faker->randomElement(['ongoing', 'completed', 'cancelled', 'archived']),
            'category'      => $this->faker->randomElement(['Project', 'Pengembangan', 'Support', 'Training', 'Konsep', 'Lainnya']),
            'priority'      => $this->faker->randomElement(['low', 'medium', 'high']),
            'user_id'       => $this->faker->numberBetween(1, 10),
        ];
    }
}
