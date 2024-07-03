<?php

namespace Database\Factories;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

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
            'tel' => fake()->regexify('[0-9]{3}-[0-9]{2}-[0-9]{2}-[0-9]{2}'),
            'codigo' => fake()->bothify('######'),
            'perfil' => fake()->randomElement(['Aplicador', 'Técnico', 'Supervisor', 'Productor']),
            'direccion' => fake()->address(),
            'observaciones' => $doObsrv ? fake()->sentence() : null,
        ];
    }

    public function withRopo(): Factory
    {
        return $this->afterCreating(function (Empresa $empresa) {
            $tipo = fake()->randomElement(['Aplicador', 'Técnico']);
            $regex1 = '^[0-9]{7,12}[S]?[ASTU]$';
            $regex2 = '^[0-9]{1,3}/[0-9]{1,3}$';
            $nro = fake()->boolean() 
                ? fake()->regexify($regex1)
                : fake()->regexify($regex2);
            $cad = fake()->dateTimeBetween('now', '+5 years')->format('Y-m-d');
            $tipo_apl = fake()->randomElement(['Básico', 'Cualificado', 'Fumigación', 'Piloto', 'Aplicación Fitosanitarios']);

            DB::table('empresa_ropo')->insert([
                'empresa_id' => $empresa->id,
                'tipo' => $tipo,
                'caducidad' => $cad,
                'nro' => $nro,
                'tipo_aplicador' => $tipo_apl,
            ]);
        });
    }
}
