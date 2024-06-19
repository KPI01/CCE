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
            ->count(25)
            ->create();

        foreach ($data as $value) {
            $doRopo = fake()->boolean(60);

            if ($doRopo) {
                $ropoNro = "";

                do {
                    if (fake()->boolean(50)) {
                        $ropoNro = fake()->regexify('/^[0-9]{9}[S]{1}[SUA]{1}[\/]{1}[0-9]{1,2}$/');
                    } else {
                        $ropoNro = fake()->regexify('/^[0-9]{2,3}[\/][0-9]{1,2}$/');
                    }
                } while (strlen($ropoNro) > 25);

                $tipo = fake()->randomElement(['Aplicador', 'Técnico']);


                DB::table('ropo')->insert([
                    'persona' => $value->id,
                    'tipo' => $tipo,
                    'caducidad' => fake()->dateTimeBetween('now', '+5 years')->format('Y-m-d'),
                    'tipo_aplicador' => $tipo ? fake()->randomElement(['Básico', 'Cualificado', 'Fumigación', 'Piloto', 'Aplicación', 'Fitosanitarios']) : null,
                    'nro' => $ropoNro,
                ]);
            }
        }
    }
}
