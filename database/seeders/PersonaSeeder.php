<?php

namespace Database\Seeders;

use App\Models\Persona;
use Illuminate\Database\Seeder;

class PersonaSeeder extends Seeder
{
    public int $count;

    public function __construct(int $count = 25)
    {
        $this->count = $count;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $c = $this->count;
        echo "Creando personas ({$c}) ..." . PHP_EOL;
        Persona::factory()->count($c)->create();

        echo "Creando personas con ROPO ({$c}) ..." . PHP_EOL;
        Persona::factory()->count($c)->withRopo()->create();
    }
}
