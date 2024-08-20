<?php

namespace Database\Seeders;

use App\Models\Maquina;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class MaquinaSeeder extends Seeder
{
    public int $c;

    public function __construct(int $count = 25)
    {
        $this->c = $count;
    }
    public function run(): void
    {
        //
        $c = $this->c;
        echo "Llenando la auxiliar: tipos_maquina ..." . PHP_EOL;
        $this->call(AuxTiposMaquinaSeeder::class);
        echo "Creando maquinas ({$c}) ..." . PHP_EOL;
        Maquina::factory($c)->create();
    }
}
