<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sports = ['Futbol', 'Baloncesto', 'Tenis', 'Natación', 'Atletismo', 'Voleibol', 'Ciclismo', 'Golf'];
        return [
            'name' => $this->faker->randomElement($sports),
        ];
    }
}
