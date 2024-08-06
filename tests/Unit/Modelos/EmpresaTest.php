<?php

namespace Tests\Unit;

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

    public function test_factory(): void
    {
        /** con make() */
        $this->inst = Empresa::factory()->make();
        $this->assertNotNull(
            $this->inst,
            "No se funcionó el factory()->make()"
        );
        $this->inst->save();
        $this->assertDatabaseHas($this->table, $this->inst->getRawOriginal());
        $this->reg = Empresa::findOrFail($this->inst->id);
        $this->assertNotNull($this->reg, "No se pudo extraer el registro");
        $this->assertDatabaseCount($this->table, 1);

        /** con create() */
        $this->inst = Empresa::factory()->create();
        $this->assertNotNull(
            $this->inst,
            "No se funcionó el factory()->create()"
        );
        $this->assertDatabaseHas($this->table, $this->inst->getRawOriginal());
        $this->reg = Empresa::findOrFail($this->inst->id);
        $this->assertNotNull($this->reg, "No se pudo extraer el registro");
        $this->assertDatabaseCount($this->table, 2);
    }

    public function test_create(): void
    {
        $this->inst = Empresa::factory()->make();
        $this->assertNotNull(
            $this->inst,
            "No se funcionó el factory()->create()"
        );
        Empresa::create($this->inst->toArray());

        $this->assertDatabaseHas($this->table, $this->inst->getRawOriginal());
        $this->assertDatabaseCount($this->table, 1);
    }
    public function test_read(): void
    {
        $this->inst = Empresa::factory()->make();
        $this->assertNotNull(
            $this->inst,
            "No se funcionó el factory()->make()"
        );
        Empresa::create($this->inst->toArray());

        $this->reg = Empresa::findOrFail($this->inst->id);
        $this->assertNotNull($this->reg, "No se pudo leer el registro");
        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $this->inst->getRawOriginal());
    }
    public function test_update(): void
    {
        /** Actualización solo de la columna 'nombres' */
        $random = fake()->firstName();

        $this->inst = Empresa::factory()->make();
        $this->assertNotNull(
            $this->inst,
            "No se funcionó el factory()->create()"
        );
        Empresa::create($this->inst->toArray());

        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $this->inst->getRawOriginal());

        $this->inst->nombre = $random;
        $this->assertEquals($random, $this->inst->nombre);
        Empresa::where("id", $this->inst->id)->update([
            "nombre" => $this->inst->nombre,
        ]);
        $this->assertDatabaseHas($this->table, $this->inst->getRawOriginal());
        $this->assertDatabaseCount($this->table, 1);
    }
    public function test_delete(): void
    {
        $this->inst = Empresa::factory()->make();
        $this->assertNotNull(
            $this->inst,
            "No se funcionó el factory()->create()"
        );
        Empresa::create($this->inst->toArray());

        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $this->inst->getRawOriginal());

        Empresa::where("id", $this->inst->id)->delete();
        $this->assertDatabaseMissing(
            $this->table,
            $this->inst->getRawOriginal()
        );
        $this->assertDatabaseEmpty($this->table);
    }

    public function test_seeder(): void
    {
        $this->seed(EmpresaSeeder::class);
        $this->assertDatabaseCount($this->table, 50);
    }
}
