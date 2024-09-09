<?php

namespace Database\Seeders;

use App\Models\Maquina;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class MaquinaSeeder extends Seeder
{
    public static int $count = 0;

    public function __construct(int $count = 25)
    {
        $this::$count = $count;
    }
    public function run(): void
    {
        //
        echo "Llenando la auxiliar: tipos_maquina ..." . PHP_EOL;
        $this->call(AuxTiposMaquinaSeeder::class);
        echo "Creando maquinas ({$this::$count}) ..." . PHP_EOL;
        Maquina::factory($this::$count)->create();
    }
}
