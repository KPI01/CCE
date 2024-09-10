<?php

namespace Database\Seeders;

use App\Models\Campana;
use Illuminate\Database\Seeder;

class CampanaSeeder extends Seeder
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
        echo "Creando campañas ({$this::$count} registros) ..." . PHP_EOL;
        Campana::factory($this::$count)->create();
    }
}
