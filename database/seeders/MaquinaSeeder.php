<?php

namespace Database\Seeders;

use App\Models\Maquina;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaquinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table(Maquina::TIPOS_TABLE)->insert([
            ["tipo" => "Pulverizador"],
            ["tipo" => "Atomizador"],
            ["tipo" => "Bomba irrigación"],
            ["tipo" => "Cuba"],
            ["tipo" => "Aplicador de aceite"],
        ]);

        $cant = 25;
        echo "Creando maquinas ($cant) ..." . PHP_EOL;
        Maquina::factory(25)->create();
    }
}
