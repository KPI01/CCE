<?php namespace Database\Factories;

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

        $tel = str_replace(" ", "", fake()->tollFreeNumber());

        return [
            //,
            "id" => fake()->unique()->uuid(),
            "nombres" => fake()->firstName(),
            "apellidos" => fake()->lastName(),
            "tipo_id_nac" => $tipo_id_nac,
            "id_nac" => $id_nac,
            "email" => fake()->unique()->safeEmail(),
            "tel" => $tel,
            "perfil" => fake()->randomElement(Persona::PERFILES),
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
            $ropo_regex1 = '^[0-9]{7,12}[S]?[ASTU]$';
            $ropo_regex2 = '^[0-9]{1,3}/[0-9]{1,3}$';
            $nro = fake()->boolean()
                ? fake()->unique()->regexify($ropo_regex1)
                : fake()->unique()->regexify($ropo_regex2);
            $cad = fake()->dateTimeBetween("now", "+5 years")->format("Y-m-d");
            $cap = fake()->randomElement([
                "Básico",
                "Cualificado",
                "Fumigador",
                "Piloto Aplicador",
            ]);

            DB::table("persona_ropo")->insert([
                "persona_id" => $persona->id,
                "caducidad" => $cad,
                "nro" => $nro,
                "capacitacion" => $cap,
            ]);
        });
    }
}
