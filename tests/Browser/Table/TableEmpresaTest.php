<?php

namespace Tests\Browser;

use App\Models\Empresa;
use Database\Seeders\EmpresaSeeder;
use Tests\TableDuskTestCase;

class TableEmpresaTest extends TableDuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->recurso = "empresa";
        $this->class = Empresa::class;
        $this->seederClass = EmpresaSeeder::class;
        $this->hasRopo = true;
    }
}
