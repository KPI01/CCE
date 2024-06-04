<?php

namespace Database\Factories;

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
        $tipo_id_nac = fake()->randomElement(['DNI', 'NIE']);

        if ($tipo_id_nac == 'DNI') {
            $id_nac = fake()->unique()->dni();
        } else if ($tipo_id_nac == 'NIE') {
            $id_nac = fake()->unique()->regexify('/[XYZ][0-9]{7}[XYZ]/');
        }

        return [
            //,
            'id' => fake()->unique()->uuid(),
            'nombres' => fake()->firstName(),
            'apellidos' => fake()->lastName(),
            'tipo_id_nac' => $tipo_id_nac,
            'id_nac' => $id_nac,
            'email' => fake()->unique()->safeEmail(),
            'tel' => fake()->phoneNumber(),
            'perfil' => fake()->word(),
            'observaciones' => fake()->boolean() ? fake()->realText(
                fake()->numberBetween(20,100)
            ) : null,
        ];
    }
}
