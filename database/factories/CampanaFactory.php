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
        $inicio = Carbon::parse(time: fake()->date())->format(format: "Y-m-d");
        $fin = Carbon::parse(
            time: fake()->dateTimeBetween(
                startDate: "now",
                endDate: "+18 months"
            )
        )->format(format: "Y-m-d");
        return [
            //
            "nombre" => fake()->year(),
            "is_activa" => fake()->randomElement(array: [0, 1]),
            "inicio" => $inicio,
            "fin" => $fin,
            "descripcion" => fake()->paragraph(nbSentences: 2),
        ];
    }
}
