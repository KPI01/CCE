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
        $tel = str_replace(" ", "", fake()->tollFreeNumber());

        return [
            //
            "nombre" => fake()->company(),
            "nif" => fake()->unique()->vat(),
            "email" => fake()->unique()->companyEmail(),
            "tel" => $tel,
            "codigo" => fake()->bothify("######"),
            "perfil" => fake()->randomElement(Empresa::PERFILES),
            "direccion" => fake()->address(),
            "observaciones" => $doObsrv ? fake()->sentence() : null,
        ];
    }

    public function withRopo(): Factory
    {
        return $this->afterCreating(function (Empresa $empresa) {
            $regex1 = '^[0-9]{7,12}[S]?[ASTU]$';
            $regex2 = '^[0-9]{1,3}/[0-9]{1,3}$';
            $nro = fake()->boolean()
                ? fake()->unique()->regexify($regex1)
                : fake()->unique()->regexify($regex2);
            $cad = fake()->dateTimeBetween("now", "+5 years")->format("Y-m-d");
            $cap = fake()->randomElement(Empresa::CAPACITACIONES_ROPO);

            DB::table("empresa_ropo")->insert([
                "empresa_id" => $empresa->id,
                "caducidad" => $cad,
                "nro" => $nro,
                "capacitacion" => $cap,
            ]);
        });
    }
}
