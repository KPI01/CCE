<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $num = 25;
        echo "Creando empresas ($num)..." . PHP_EOL;
        Empresa::factory(25)->create();
        echo "Creando empresas con ROPO ($num)..." . PHP_EOL;
        Empresa::factory(25)->withRopo()->create();
    }
}
