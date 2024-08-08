<?php

namespace Database\Seeders;

use App\Models\Maquina;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Schema;

class MaquinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Schema::disableForeignKeyConstraints();
        DB::table(Maquina::TIPOS_TABLE)->truncate();
        DB::table(Maquina::TIPOS_TABLE)->insert([
            ["nombre" => "Pulverizador"],
            ["nombre" => "Atomizador"],
            ["nombre" => "Bomba irrigación"],
            ["nombre" => "Cuba"],
            ["nombre" => "Aplicador de aceite"],
        ]);

        $cant = 25;
        echo "Creando maquinas ($cant) ..." . PHP_EOL;
        Maquina::factory(25)->create();
    }
}
