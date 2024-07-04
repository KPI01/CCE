<?php

namespace Tests\Unit;

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

    public function test_factory(): void
    {
        /** con make() */
        $this->inst = Persona::factory()->make();
        $this->assertNotNull(
            $this->inst,
            "No se funcionó el factory()->make()"
        );
        $this->inst->save();
        $this->assertDatabaseHas($this->table, $this->inst->getRawOriginal());
        $this->reg = Persona::findOrFail($this->inst->id);
        $this->assertNotNull($this->reg, "No se pudo extraer el registro");
        $this->assertDatabaseCount($this->table, 1);

        /** con create() */
        $this->inst = Persona::factory()->create();
        $this->assertNotNull(
            $this->inst,
            "No se funcionó el factory()->create()"
        );
        $this->assertDatabaseHas($this->table, $this->inst->getRawOriginal());
        $this->reg = Persona::findOrFail($this->inst->id);
        $this->assertNotNull($this->reg, "No se pudo extraer el registro");
        $this->assertDatabaseCount($this->table, 2);
    }

    public function test_create(): void
    {
        $this->inst = Persona::factory()->make();
        $this->assertNotNull(
            $this->inst,
            "No se funcionó el factory()->create()"
        );
        Persona::create($this->inst->toArray());

        $this->assertDatabaseHas($this->table, $this->inst->getRawOriginal());
        $this->assertDatabaseCount($this->table, 1);
    }
    public function test_read(): void
    {
        $this->inst = Persona::factory()->make();
        $this->assertNotNull(
            $this->inst,
            "No se funcionó el factory()->make()"
        );
        Persona::create($this->inst->toArray());

        $this->reg = Persona::findOrFail($this->inst->id);
        $this->assertNotNull($this->reg, "No se pudo leer el registro");
        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $this->inst->getRawOriginal());
    }
    public function test_update(): void
    {
        /** Actualización solo de la columna 'nombres' */
        $random = fake()->firstName();

        $this->inst = Persona::factory()->make();
        $this->assertNotNull(
            $this->inst,
            "No se funcionó el factory()->create()"
        );
        Persona::create($this->inst->toArray());

        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $this->inst->getRawOriginal());

        $this->inst->nombres = $random;
        $this->assertEquals($random, $this->inst->nombres);
        Persona::where("id", $this->inst->id)->update([
            "nombres" => $this->inst->nombres,
        ]);
        $this->assertDatabaseHas($this->table, $this->inst->getRawOriginal());
        $this->assertDatabaseCount($this->table, 1);
    }
    public function test_delete(): void
    {
        $this->inst = Persona::factory()->make();
        $this->assertNotNull(
            $this->inst,
            "No se funcionó el factory()->create()"
        );
        Persona::create($this->inst->toArray());

        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $this->inst->getRawOriginal());

        Persona::where("id", $this->inst->id)->delete();
        $this->assertDatabaseMissing(
            $this->table,
            $this->inst->getRawOriginal()
        );
        $this->assertDatabaseEmpty($this->table);
    }

    public function test_seeder(): void
    {
        $this->seed(PersonaSeeder::class);
        $this->assertDatabaseCount($this->table, 50);
    }
}
