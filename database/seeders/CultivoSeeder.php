<?php

namespace Database\Seeders;

use App\Models\Cultivo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CultivoSeeder extends Seeder
{
    public static int $count = 0;

    public function __construct(int $count = 25)
    {
        $this::$count = $count;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        echo "Creando cultivos ({$this::$count}) ..." . PHP_EOL;
        Cultivo::factory($this::$count)->create();
    }
}
