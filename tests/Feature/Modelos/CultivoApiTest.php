<?php

namespace Tests\Feature\Modelos;

use App\Models\Cultivo;
use App\Models\User;
use Illuminate\Support\Arr;
use Tests\TestCase;

class CultivoApiTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->actingAs(
            user: User::where(
                column: "email",
                operator: "=",
                value: "informatica@fruveco.com"
            )->first()
        );
    }
    public function testIndexAll()
    {
        $count = Cultivo::count();
        $response = $this->get(
            uri: route(name: "cultivo.api.index"),
            headers: ["Accept" => "application/json"]
        );

        $response->assertStatus(200);
        $response->assertJsonCount($count);
        $response->assertJson(Cultivo::all()->toArray());
    }
    public function testIndexOne()
    {
        $random = Cultivo::inRandomOrder()->first();
        $response = $this->get(
            uri: route(
                name: "cultivo.api.index",
                parameters: ["id" => $random->codigo]
            ),
            headers: ["Accept" => "application/json"]
        );

        $response->assertStatus(200);
        $response->assertJson(Cultivo::find($random->codigo)->toArray());
    }

    public function testUpdate()
    {
        $random = Cultivo::inRandomOrder()->first();

        $data = [
            "nombre" => ucfirst(fake()->word()),
            "variedad" => ucfirst(fake()->word()),
        ];

        $response = $this->put(
            uri: route(
                name: "cultivo.api.update",
                parameters: ["cultivo" => $random->codigo]
            ) .
                "?" .
                http_build_query($data)
        );

        $random->refresh();

        $response
            ->assertStatus(200)
            ->assertJson(
                $data + Arr::except($random->toArray(), ["nombre", "variedad"])
            );
    }

    public function testDestroy()
    {
        $random = Cultivo::inRandomOrder()->first();

        $response = $this->delete(
            uri: route(
                name: "cultivo.api.destroy",
                parameters: ["cultivo" => $random->codigo]
            )
        );

        $response->assertStatus(204);
    }
}
