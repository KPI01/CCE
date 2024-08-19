<?php

namespace Tests\Unit\Modelos;

use App\Models\Persona;
use Database\Seeders\PersonaSeeder;
use Illuminate\Support\Facades\Schema;
use Tests\ModeloTestCase;

class PersonaTest extends ModeloTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Schema::disableForeignKeyConstraints();
        Persona::truncate();
        $this->table = (new Persona())->getTable();
    }

    public function testFactory(): void
    {
        /** con make() */
        $inst = Persona::factory()->make();
        $this->assertNotNull($inst, "No funcionó el factory()->make()");
        $inst->save();
        $this->assertDatabaseHas($this->table, $inst->getAttributes());
        $reg = Persona::findOrFail($inst->id);
        $this->assertNotNull($reg, "No se pudo extraer el registro");
        $this->assertDatabaseCount($this->table, 1);

        /** con create() */
        $inst = Persona::factory()->create();
        $this->assertNotNull($inst, "No funcionó el factory()->create()");
        $this->assertDatabaseHas($this->table, $inst->getAttributes());
        $reg = Persona::findOrFail($inst->id);
        $this->assertNotNull($reg, "No se pudo extraer el registro");
        $this->assertDatabaseCount($this->table, 2);
    }

    public function testCreate(): void
    {
        $inst = Persona::factory()->make();
        $this->assertNotNull($inst, "No se funcionó el factory()->create()");
        $inst->save();
        $this->assertDatabaseHas($this->table, $inst->getAttributes());
        $this->assertDatabaseCount($this->table, 1);
    }
    public function testRead(): void
    {
        $inst = Persona::factory()->make();
        $this->assertNotNull($inst, "No se funcionó el factory()->make()");
        $inst->save();
        $reg = Persona::findOrFail($inst->id);
        $this->assertNotNull($reg, "No se pudo leer el registro");
        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $inst->getAttributes());
    }
    public function testUpdate(): void
    {
        /** Actualización solo de la columna 'nombres' */
        $random = fake()->firstName();

        $inst = Persona::factory()->make();
        $this->assertNotNull($inst, "No se funcionó el factory()->create()");
        Persona::create($inst->toArray());

        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $inst->getAttributes());

        $inst->nombres = $random;
        $this->assertEquals($random, $inst->nombres);
        Persona::where("id", $inst->id)->update([
            "nombres" => $inst->nombres,
        ]);
        $this->assertDatabaseHas($this->table, $inst->getAttributes());
        $this->assertDatabaseCount($this->table, 1);
    }
    public function testDelete(): void
    {
        $inst = Persona::factory()->make();
        $this->assertNotNull($inst, "No se funcionó el factory()->create()");
        Persona::create($inst->toArray());

        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $inst->getAttributes());

        Persona::where("id", $inst->id)->delete();
        $this->assertDatabaseMissing($this->table, $inst->getAttributes());
        $this->assertDatabaseEmpty($this->table);
    }

    public function testSeeder(): void
    {
        $this->seed(PersonaSeeder::class);
        $this->assertDatabaseCount($this->table, 50);
    }
}
