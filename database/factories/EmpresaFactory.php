<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empresa>
 */
class EmpresaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $doObsrv = fake()->boolean();
        return [
            //
            'id' => fake()->uuid(),
            'nombre' => fake()->company(),
            'nif' => fake()->unique()->regexify('[0-9]{8}[A-Z]'),
            'email' => fake()->unique()->companyEmail(),
            'tel' => fake()->phoneNumber(),
            'codigo' => fake()->bothify('######'),
            'perfil' => fake()->word(),
            'direccion' => fake()->address(),
            'observaciones' => $doObsrv ? fake()->sentence() : null,
        ];
    }
}
