<?php

namespace Tests\Browser\Table;

use App\Models\Campana;
use Database\Seeders\CampanaSeeder;
use Tests\TableDuskTestCase;

class TableCampanaTest extends TableDuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->recurso = "campana";
        $this->class = Campana::class;
        $this->seederClass = CampanaSeeder::class;
    }
}
