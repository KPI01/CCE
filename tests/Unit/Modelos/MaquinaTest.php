<?php

namespace Tests\Unit\Modelos;

use App\Models\Maquina;
use Database\Seeders\MaquinaSeeder;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\TestCase;
use Tests\ModeloTestCase;

class MaquinaTest extends ModeloTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Schema::disableForeignKeyConstraints();
        Maquina::truncate();
        $this->table = (new Maquina())->getTable();
    }

    public function testFactory(): void
    {
        /** make() */
        $inst = Maquina::factory()->make();
        $this->assertNotNull($inst, "factory()->make() no funcionó");
        $inst->save();
        $reg = Maquina::findOrFail($inst->id);
        $this->assertNotNull($reg, "No se pudo extraer el registro");
        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $reg->getAttributes());

        /** create() */
        $inst = Maquina::factory()->create();
        $this->assertNotNull($inst, "factory()->create() no funcionó");
        $this->assertDatabaseHas($this->table, $inst->getAttributes());
        $reg = Maquina::findOrFail($inst->id);
        $this->assertNotNull($reg, "No se pudo extraer el registro");
        $this->assertDatabaseCount($this->table, 2);
    }

    public function testCreate(): void
    {
        $inst = Maquina::factory()->make();
        $this->assertNotNull($inst, "factory()->make() no funcionó");
        $inst->save();
        $this->assertDatabaseHas($this->table, $inst->getAttributes());
        $this->assertDatabaseCount($this->table, 1);
    }

    public function testRead(): void
    {
        $inst = Maquina::factory()->make();
        $this->assertNotNull($inst, "factory()->make() no funcionó");
        $inst->save();
        $reg = Maquina::findOrFail($inst->id);
        $this->assertNotNull($reg, "No se pudo extraer el registro");
        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $reg->getAttributes());
    }

    public function testUpdate(): void
    {
        $inst = Maquina::factory()->make();
        $this->assertNotNull($inst, "factory()->make() no funcionó");
        $inst->save();

        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $inst->getAttributes());

        $fakeData = [
            "nombre" => fake()->sentence(2),
            "roma" => fake()->bothify("??##-###"),
            "nro_serie" => fake()->bothify("??##-###"),
        ];

        $inst->update($fakeData);

        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $fakeData);
    }

    public function testDelete(): void
    {
        $inst = Maquina::factory()->make();
        $this->assertNotNull($inst, "factory()->make() no funcionó");
        $inst->save();

        $this->assertDatabaseCount($this->table, 1);
        $this->assertDatabaseHas($this->table, $inst->getAttributes());

        $inst->delete();

        $this->assertDatabaseCount($this->table, 0);
    }

    public function testSeeder(): void
    {
        $this->seed(MaquinaSeeder::class);
        $this->assertDatabaseCount($this->table, MaquinaSeeder::$count);
    }
}
