<?php

namespace Database\Seeders;

use App\Models\Persona;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $num = 25;
        echo "Creando personas ($num) ..." . PHP_EOL;
        Persona::factory()->count($num)->create();

        echo "Creando personas con ROPO ($num) ..." . PHP_EOL;
        Persona::factory()->count($num)->withRopo()->create();
    }
}
