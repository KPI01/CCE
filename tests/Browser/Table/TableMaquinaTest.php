<?php

namespace Tests\Browser\Table;

use App\Models\Maquina;
use Database\Seeders\MaquinaSeeder;
use Tests\TableDuskTestCase;

class TableMaquinaTest extends TableDuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->recurso = "maquina";
        $this->class = Maquina::class;
        $this->seederClass = MaquinaSeeder::class;
    }
}
