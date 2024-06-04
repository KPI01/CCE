<?php

namespace Database\Seeders;

use App\Models\Empresa;
use App\Models\EmpresaPersona;
use App\Models\Persona;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpresaPersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Persona::factory()
            ->count(5)
            ->hasAttached(
                Empresa::factory()

            )
            ->create();
    }
}
