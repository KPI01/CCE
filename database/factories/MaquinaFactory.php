<?php

namespace Database\Factories;

use App\Models\Maquina;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Maquina>
 */
class MaquinaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipos = DB::table(Maquina::TIPOS_TABLE)
            ->pluck("id")
            ->toArray();
        return [
            //
            "id" => fake()->unique()->uuid(),
            "nombre" => fake()->sentence(2),
            "matricula" => fake()->bothify("??##??##??##??##"),
            "modelo" => fake()->word(),
            "marca" => fake()->word(),
            "roma" => fake()->bothify("??##??##??##??##"),
            "nro_serie" => fake()->bothify("??##??##??##??##"),
            "tipo_id" => fake()->randomElement($tipos),
            "fabricante" => fake()->company(),
            "cad_iteaf" => fake()->dateTimeBetween("now", "+7years"),
            "observaciones" => fake()->sentence(3),
        ];
    }
}
