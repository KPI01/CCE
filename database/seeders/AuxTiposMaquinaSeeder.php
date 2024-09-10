<?php

namespace Database\Seeders;

use App\Models\Maquina;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AuxTiposMaquinaSeeder extends Seeder
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
    }
}
