<?php

namespace Database\Seeders;

use App\Models\Persona;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = Persona::factory()
            ->count(10)
            ->create();

        foreach ($data as $value) {
            $doRopo = fake()->boolean(60);

            if ($doRopo) {
                $tipo = fake()->randomElement(['Aplicador', 'Técnico']);
                DB::table('ropo')->insert([
                    'persona' => $value->id,
                    'tipo' => $tipo,
                    'caducidad' => fake()->date(),
                    'tipo_aplicador' => $tipo === 'Aplicador' ? fake()->word() : null,
                    'nro' => fake()->randomElement([fake()->unique()->bothify('##########??/#'), fake()->unique()->bothify('##########??'), fake()->unique()->numerify('##/##')]),
                ]);
            }
        }
    }
}
