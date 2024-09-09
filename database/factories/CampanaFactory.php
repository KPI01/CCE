<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campana>
 */
class CampanaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            "nombre" => fake()->year(),
            "is_activa" => fake()->boolean(),
            "inicio" => fake()->date(),
            "fin" => fake()->date(),
            "descripcion" => fake()->paragraph(2),
        ];
    }
}
