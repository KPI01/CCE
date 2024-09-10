<?php

namespace Tests\Browser\Table;

use App\Models\Persona;
use Database\Seeders\PersonaSeeder;
use Tests\TableDuskTestCase;

class TablePersonaTest extends TableDuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->recurso = "persona";
        $this->class = Persona::class;
        $this->seederClass = PersonaSeeder::class;
        $this->hasRopo = true;
    }
}
