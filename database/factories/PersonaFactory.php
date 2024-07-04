<?php

namespace Database\Factories;

use App\Models\Persona;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Persona>
 */
class PersonaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipo_id_nac = fake()->randomElement(["DNI", "NIE"]);

        if ($tipo_id_nac == "DNI") {
            $id_nac = fake()->unique()->dni();
        } elseif ($tipo_id_nac == "NIE") {
            $id_nac = fake()->unique()->regexify("/[XYZ][0-9]{7}[XYZ]/");
        }

        return [
            //,
            "id" => fake()->unique()->uuid(),
            "nombres" => fake()->firstName(),
            "apellidos" => fake()->lastName(),
            "tipo_id_nac" => $tipo_id_nac,
            "id_nac" => $id_nac,
            "email" => fake()->unique()->safeEmail(),
            "tel" => fake()->regexify(
                '/^[0-9]{3}-[0-9]{2}-[0-9]{2}-[0-9]{2}$/'
            ),
            "perfil" => fake()->randomElement([
                "Aplicador",
                "Técnico",
                "Supervisor",
                "Productor",
            ]),
            "observaciones" => fake()->boolean()
                ? fake()->realText(fake()->numberBetween(20, 100))
                : null,
        ];
    }

    /**
     * Crea un registros ROPO para la persona
     */
    public function withRopo(): Factory
    {
        return $this->afterCreating(function (Persona $persona) {
            $tipo = fake()->randomElement(["Aplicador", "Técnico"]);
            $regex1 = '^[0-9]{7,12}[S]?[ASTU]$';
            $regex2 = '^[0-9]{1,3}/[0-9]{1,3}$';
            $nro = fake()->boolean()
                ? fake()->regexify($regex1)
                : fake()->regexify($regex2);
            $cad = fake()->dateTimeBetween("now", "+5 years")->format("Y-m-d");
            $tipo_apl = fake()->randomElement([
                "Básico",
                "Cualificado",
                "Fumigación",
                "Piloto",
                "Aplicación Fitosanitarios",
            ]);

            DB::table("persona_ropo")->insert([
                "persona_id" => $persona->id,
                "tipo" => $tipo,
                "caducidad" => $cad,
                "nro" => $nro,
                "tipo_aplicador" => $tipo_apl,
            ]);
        });
    }
}
