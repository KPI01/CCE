<?php

namespace Tests\Unit\Modelos;

use App\Models\Campana;
use Database\Seeders\CampanaSeeder;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\TestCase;
use Tests\ModeloTestCase;

class CampanaTest extends ModeloTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Schema::disableForeignKeyConstraints();
        Campana::truncate();
        $this->table = (new Campana())->getTable();
    }

    public function testFactory(): void
    {
        /** make() */
        $inst = Campana::factory()->make();
        $this->assertNotNull($inst, "factory()->make() no funcionó");
        $inst->save();
        $reg = Campana::findOrFail($inst->id);
        $this->assertNotNull($reg, "No se pudo extraer el registro");
        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $reg->getAttributes());

        /** create() */
        $inst = Campana::factory()->create();
        $this->assertNotNull($inst, "factory()->create() no funcionó");
        $this->assertDatabaseHas($this->table, $inst->getAttributes());
        $reg = Campana::findOrFail($inst->id);
        $this->assertNotNull($reg, "No se pudo extraer el registro");
        $this->assertDatabaseCount($this->table, 2);
    }

    public function testCreate(): void
    {
        $inst = Campana::factory()->make();
        $this->assertNotNull($inst, "factory()->make() no funcionó");
        $inst->save();
        $this->assertDatabaseHas($this->table, $inst->getAttributes());
        $this->assertDatabaseCount($this->table, 1);
    }

    public function testRead(): void
    {
        $inst = Campana::factory()->make();
        $this->assertNotNull($inst, "factory()->make() no funcionó");
        $inst->save();
        $reg = Campana::findOrFail($inst->id);
        $this->assertNotNull($reg, "No se pudo extraer el registro");
        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $reg->getAttributes());
    }

    public function testUpdate(): void
    {
        $inst = Campana::factory()->make();
        $this->assertNotNull($inst, "factory()->make() no funcionó");
        $inst->save();

        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $inst->getAttributes());

        $fakeData = [
            "nombre" => fake()->year(),
            "is_activa" => fake()->boolean(),
            "inicio" => fake()->date(),
            "fin" => fake()->date(),
        ];

        $inst->update($fakeData);

        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $fakeData);
    }

    public function testDelete(): void
    {
        $inst = Campana::factory()->make();
        $this->assertNotNull($inst, "factory()->make() no funcionó");
        $inst->save();

        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $inst->getAttributes());

        $inst->delete();

        $this->assertDatabaseCount($this->table, 0);
    }

    public function testSeeder(): void
    {
        $this->seed(CampanaSeeder::class);
        $this->assertDatabaseCount($this->table, CampanaSeeder::$count);
    }
}
