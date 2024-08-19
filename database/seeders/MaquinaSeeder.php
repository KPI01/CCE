<?php

namespace Database\Seeders;

use App\Models\Maquina;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class MaquinaSeeder extends Seeder
{
    public static int $count;

    public function __construct(int $count = 25)
    {
        self::$count = $count;
    }
    public function run(): void
    {
        //
        $count = self::$count;
        Schema::disableForeignKeyConstraints();
        echo "Llenando la auxiliar: tipos_maquina ..." . PHP_EOL;
        $this->call(AuxTiposMaquinaSeeder::class);
        echo "Creando maquinas ({$count}) ..." . PHP_EOL;
        Maquina::factory($count)->create();
    }
}
