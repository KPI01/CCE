<?php

namespace Tests\Unit\Modelos;

use App\Models\Empresa;
use Database\Seeders\EmpresaSeeder;
use Illuminate\Support\Facades\Schema;
use Tests\ModeloTestCase;

class EmpresaTest extends ModeloTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Schema::disableForeignKeyConstraints();
        Empresa::truncate();
        $this->table = (new Empresa())->getTable();
    }

    public function testFactory(): void
    {
        /** con make() */
        $inst = Empresa::factory()->make();
        $this->assertNotNull($inst, "No funcionó el factory()->make()");
        $inst->save();
        $this->assertDatabaseHas($this->table, $inst->getAttributes());
        $reg = Empresa::findOrFail($inst->id);
        $this->assertNotNull($reg, "No se pudo extraer el registro");
        $this->assertDatabaseCount($this->table, 1);

        /** con create() */
        $inst = Empresa::factory()->create();
        $this->assertNotNull($inst, "No funcionó el factory()->create()");
        $this->assertDatabaseHas($this->table, $inst->getAttributes());
        $reg = Empresa::findOrFail($inst->id);
        $this->assertNotNull($reg, "No se pudo extraer el registro");
        $this->assertDatabaseCount($this->table, 2);
    }

    public function testCreate(): void
    {
        $inst = Empresa::factory()->make();
        $this->assertNotNull($inst, "No se funcionó el factory()->create()");
        Empresa::create($inst->toArray());

        $this->assertDatabaseHas($this->table, $inst->getAttributes());
        $this->assertDatabaseCount($this->table, 1);
    }
    public function testRead(): void
    {
        $inst = Empresa::factory()->make();
        $this->assertNotNull($inst, "No se funcionó el factory()->make()");
        Empresa::create($inst->toArray());

        $reg = Empresa::findOrFail($inst->id);
        $this->assertNotNull($reg, "No se pudo leer el registro");
        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $inst->getAttributes());
    }
    public function testUpdate(): void
    {
        /** Actualización solo de la columna 'nombres' */
        $random = fake()->firstName();

        $inst = Empresa::factory()->make();
        $this->assertNotNull($inst, "No se funcionó el factory()->create()");
        Empresa::create($inst->toArray());

        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $inst->getAttributes());

        $inst->nombre = $random;
        $this->assertEquals($random, $inst->nombre);
        Empresa::where("id", $inst->id)->update([
            "nombre" => $inst->nombre,
        ]);
        $this->assertDatabaseHas($this->table, $inst->getAttributes());
        $this->assertDatabaseCount($this->table, 1);
    }
    public function testDelete(): void
    {
        $inst = Empresa::factory()->make();
        $this->assertNotNull($inst, "No se funcionó el factory()->create()");
        Empresa::create($inst->toArray());

        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $inst->getAttributes());

        Empresa::where("id", $inst->id)->delete();
        $this->assertDatabaseMissing($this->table, $inst->getAttributes());
        $this->assertDatabaseEmpty($this->table);
    }

    public function testSeeder(): void
    {
        $this->seed(EmpresaSeeder::class);
        $this->assertDatabaseCount($this->table, 50);
    }
}
