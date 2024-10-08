<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cultivo>
 */
class CultivoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $variedad = fake()->boolean() ? fake()->word() : null;
        return [
            //
            "nombre" => ucfirst(fake()->word()),
            "variedad" => $variedad,
        ];
    }
}
