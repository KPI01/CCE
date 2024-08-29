<?php

namespace Database\Factories;

use App\Models\Maquina;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
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
            "matricula" => fake()->regexify("[A-Z0-9]{10}"),
            "modelo" => fake()->word(),
            "marca" => fake()->word(),
            "roma" => fake()->bothify("??##??##??##??##"),
            "nro_serie" => fake()->regexify("[A-Z0-9]{15}"),
            "tipo_id" => fake()->randomElement($tipos),
            "fabricante" => fake()->company(),
            "cad_iteaf" => Carbon::parse(
                fake()->dateTimeBetween("now", "+7years")
            )->format("Y-m-d"),
            "observaciones" => fake()->sentence(3),
        ];
    }
}
