<?php

namespace Tests\Unit\Modelos;

use App\Models\Cultivo;
use Database\Seeders\CultivoSeeder;
use Illuminate\Support\Facades\Schema;
use Tests\ModeloTestCase;

class CultivoTest extends ModeloTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Schema::disableForeignKeyConstraints();
        Cultivo::truncate();
        $this->table = (new Cultivo())->getTable();
    }

    public function testCreate(): void
    {
        $inst = Cultivo::factory()->make();
        $this->assertNotNull($inst, "factory()->make() no funcionó");
        $inst->save();
        $this->assertDatabaseHas($this->table, $inst->getAttributes());
        $this->assertDatabaseCount($this->table, 1);
    }

    public function testRead(): void
    {
        $inst = Cultivo::factory(1)->make()->first();
        $this->assertNotNull($inst, "factory()->make() no funcionó");
        $inst->save();
        $reg = Cultivo::findOrFail($inst->codigo);
        $this->assertNotNull($reg, "No se pudo extraer el registro");
        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $reg->getAttributes());
    }

    public function testUpdate(): void
    {
        $inst = Cultivo::factory()->make();
        $this->assertNotNull($inst, "factory()->make() no funcionó");
        $inst->save();

        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $inst->getAttributes());

        $fakeData = [
            "nombre" => ucfirst(fake()->word()),
            "variedad" => ucfirst(fake()->word()),
        ];

        $inst->update($fakeData);

        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $fakeData);
    }

    public function testDelete(): void
    {
        $inst = Cultivo::factory(1)->make()->first();
        $this->assertNotNull($inst, "factory()->make() no funcionó");
        $inst->save();

        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $inst->getAttributes());

        $inst->delete();

        $this->assertDatabaseCount($this->table, 0);
    }

    public function testFactory(): void
    {
        /** make() */
        $inst = Cultivo::factory()->make();
        $this->assertNotNull($inst, "factory()->make() no funcionó");
        $inst->save();
        $reg = Cultivo::findOrFail($inst->codigo);
        $this->assertNotNull($reg, "No se pudo extraer el registro");
        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $reg->getAttributes());

        /** create() */
        $inst = Cultivo::factory()->create();
        $this->assertNotNull($inst, "factory()->create() no funcionó");
        $this->assertDatabaseHas($this->table, $inst->getAttributes());
        $reg = Cultivo::findOrFail($inst->codigo);
        $this->assertNotNull($reg, "No se pudo extraer el registro");
        $this->assertDatabaseCount($this->table, 2);
    }

    public function testSeeder(): void
    {
        $this->seed(CultivoSeeder::class);
        $this->assertDatabaseCount($this->table, CultivoSeeder::$count);
    }
}
