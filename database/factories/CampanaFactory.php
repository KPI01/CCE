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
        $inicio = Carbon::parse(fake()->date());
        $fin = Carbon::parse(fake()->dateTimeBetween("now", "+18 months"));
        return [
            //
            "nombre" => fake()->year(),
            "is_activa" => fake()->boolean(),
            "inicio" => $inicio,
            "fin" => $fin,
            "descripcion" => fake()->paragraph(2),
        ];
    }
}
