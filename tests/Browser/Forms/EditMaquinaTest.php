<?php

namespace Tests\Browser\Edit;

use App\Models\Maquina;
use Carbon\Carbon;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Recursos\Form;
use Illuminate\Support\Arr;
use Tests\RecursoDuskTestCase;

class EditMaquinaTest extends RecursoDuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->hasDeleteBtn = true;
        $this->class = Maquina::class;
        $this->recurso = "maquina";
        $this->row = Maquina::factory(
            count: 1,
            state: [
                "tipo_id" => 1,
            ]
        )
            ->create()
            ->first();
        $this->PARAMS = [$this->recurso, "edit", $this->row->id];
    }

    public function testAccesibilidad(): void
    {
        parent::testAccesibilidad();
        $this->browse(
            callback: function (Browser $browser): void {
                $browser->visit(url: new Form(...$this->PARAMS));

                $browser
                    ->assertPresent(selector: "@breadcrumb")
                    ->assertPresent(selector: "@title")
                    ->assertPresent(selector: "@form-edit-{$this->row->id}")
                    ->assertPresent(selector: "@badge-createdAt")
                    ->assertPresent(selector: "@badge-updatedAt");

                $browser
                    ->assertPresent(selector: "@label-nombre")
                    ->assertPresent(selector: "@label-matricula")
                    ->assertPresent(selector: "@label-tipo")
                    ->assertPresent(selector: "@label-fabricante")
                    ->assertPresent(selector: "@label-modelo")
                    ->assertPresent(selector: "@label-marca")
                    ->assertPresent(selector: "@label-roma")
                    ->assertPresent(selector: "@label-nro_serie")
                    ->assertPresent(selector: "@label-cad_iteaf")
                    ->assertPresent(selector: "@label-observaciones");

                $browser
                    ->assertPresent(selector: "@input-nombre")
                    ->assertPresent(selector: "@input-matricula")
                    ->assertPresent(selector: "@trigger-tipo")
                    ->assertPresentByName("select", "tipo")
                    ->assertPresent(selector: "@input-fabricante")
                    ->assertPresent(selector: "@input-modelo")
                    ->assertPresent(selector: "@input-marca")
                    ->assertPresent(selector: "@input-roma")
                    ->assertPresent(selector: "@input-nro_serie")
                    ->assertPresent(selector: "@input-cad_iteaf")
                    ->assertPresent(selector: "@txt-observaciones");
            }
        );
    }

    public function testVisibilidad(): void
    {
        parent::testVisibilidad();
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->assertVisible("@breadcrumb")
                ->assertVisible("@title")
                ->assertVisible("@form-edit-{$this->PARAMS[2]}")
                ->assertVisible("@badge-createdAt")
                ->assertVisible("@badge-updatedAt");

            $browser
                ->assertVisible("@label-nombre")
                ->assertVisible("@label-matricula")
                ->assertVisible("@label-tipo")
                ->assertVisible("@label-fabricante")
                ->assertVisible("@label-modelo")
                ->assertVisible("@label-marca")
                ->assertVisible("@label-roma")
                ->assertVisible("@label-nro_serie")
                ->assertVisible("@label-cad_iteaf")
                ->assertVisible("@label-observaciones");

            $browser
                ->assertVisible("@input-nombre")
                ->assertVisible("@input-matricula")
                ->assertVisible("@trigger-tipo")
                ->assertVisibleByName("select", "tipo")
                ->assertVisible("@input-fabricante")
                ->assertVisible("@input-modelo")
                ->assertVisible("@input-marca")
                ->assertVisible("@input-roma")
                ->assertVisible("@input-nro_serie")
                ->assertVisible("@trigger-cad_iteaf")
                ->assertVisible("@txt-observaciones");
        });
    }

    public function testCamposHabilitados(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->assertEnabled("@input-nombre")
                ->assertEnabled("@input-matricula")
                ->assertEnabled("@trigger-tipo")
                ->assertEnabledByName("select", "tipo")
                ->assertEnabled("@input-fabricante")
                ->assertEnabled("@input-modelo")
                ->assertEnabled("@input-marca")
                ->assertEnabled("@input-roma")
                ->assertEnabled("@input-nro_serie")
                ->assertEnabled("@trigger-cad_iteaf")
                ->assertEnabled("@txt-observaciones");
        });
    }

    public function testValidacionInformacion(): void
    {
        $this->browse(
            callback: function (Browser $browser): void {
                $browser->visit(url: new Form(...$this->PARAMS));

                $browser
                    ->assertInputValue(
                        field: "@input-nombre",
                        value: $this->row->nombre
                    )
                    ->assertInputValue(
                        field: "@input-matricula",
                        value: $this->row->matricula
                    )
                    ->assertSeeIn(
                        selector: "@trigger-tipo",
                        text: $this->row->tipo
                    )
                    ->assertInputValue(
                        field: "@input-fabricante",
                        value: $this->row->fabricante
                    )
                    ->assertInputValue(
                        field: "@input-modelo",
                        value: $this->row->modelo
                    )
                    ->assertInputValue(
                        field: "@input-marca",
                        value: $this->row->marca
                    )
                    ->assertInputValue(
                        field: "@input-roma",
                        value: $this->row->roma
                    )
                    ->assertInputValue(
                        field: "@input-nro_serie",
                        value: $this->row->nro_serie
                    )
                    ->assertSeeIn(
                        selector: "@trigger-cad_iteaf",
                        text: Carbon::parse(
                            time: $this->row->cad_iteaf
                        )->format(format: "d/m/Y")
                    )
                    ->assertInputValue(
                        field: "@txt-observaciones",
                        value: $this->row->observaciones
                    );
            }
        );
    }

    public function testEnvioRequeridosVacios(): void
    {
        $this->browse(
            callback: function (Browser $browser): void {
                $browser->visit(url: new Form(...$this->PARAMS));

                for ($i = 0; $i < strlen(string: $this->row->nombre); $i++) {
                    $browser->keys(
                        selector: "@input-nombre",
                        keys: "{backspace}"
                    );
                }
                $browser->assertInputValue(field: "@input-nombre", value: "");

                for ($i = 0; $i < strlen(string: $this->row->matricula); $i++) {
                    $browser->keys(
                        selector: "@input-matricula",
                        keys: "{backspace}"
                    );
                }
                $browser->assertInputValue(
                    field: "@input-matricula",
                    value: ""
                );

                $browser
                    ->press(button: "@submit")
                    ->assertSeeIn(
                        selector: "@msg-nombre",
                        text: "El nombre es requerido"
                    )
                    ->assertSeeIn(
                        selector: "@msg-matricula",
                        text: "La matrícula es requerida"
                    );
            }
        );
    }

    public function testCamposVaciados(): void
    {
        $this->browse(
            callback: function (Browser $browser): void {
                $browser->visit(url: new Form(...$this->PARAMS));

                for ($i = 0; $i < strlen(string: $this->row->nro_serie); $i++) {
                    $browser->keys(
                        selector: "@input-nro_serie",
                        keys: "{backspace}"
                    );
                }
                $browser->assertInputValue(
                    field: "@input-nro_serie",
                    value: ""
                );
                for (
                    $i = 0;
                    $i < strlen(string: $this->row->fabricante);
                    $i++
                ) {
                    $browser->keys(
                        selector: "@input-fabricante",
                        keys: "{backspace}"
                    );
                }
                $browser->assertInputValue(
                    field: "@input-fabricante",
                    value: ""
                );
                for ($i = 0; $i < strlen(string: $this->row->marca); $i++) {
                    $browser->keys(
                        selector: "@input-marca",
                        keys: "{backspace}"
                    );
                }
                $browser->assertInputValue(field: "@input-marca", value: "");
                for ($i = 0; $i < strlen(string: $this->row->modelo); $i++) {
                    $browser->keys(
                        selector: "@input-modelo",
                        keys: "{backspace}"
                    );
                }
                $browser->assertInputValue(field: "@input-modelo", value: "");
                for ($i = 0; $i < strlen(string: $this->row->roma); $i++) {
                    $browser->keys(
                        selector: "@input-roma",
                        keys: "{backspace}"
                    );
                }
                $browser->assertInputValue(field: "@input-roma", value: "");
                for (
                    $i = 0;
                    $i < strlen(string: $this->row->observaciones);
                    $i++
                ) {
                    $browser->keys(
                        selector: "@txt-observaciones",
                        keys: "{backspace}"
                    );
                }
                $browser->assertInputValue(
                    field: "@txt-observaciones",
                    value: ""
                );

                $browser
                    ->press(button: "@submit")
                    ->pause(milliseconds: 1000)
                    ->assertRouteIs(
                        route: "maquina.show",
                        parameters: [$this->recurso => $this->row->id]
                    );
            }
        );

        $attr = Arr::only(
            array: $this->row->getAttributes(),
            keys: ["id", "nombre", "matricula", "tipo_id"]
        );
        $this->assertDatabaseHas(table: $this->class, data: $attr);

        $attr = Arr::except(
            array: $this->row->getAttributes(),
            keys: [
                "id",
                "created_at",
                "updated_at",
                "nombre",
                "matricula",
                "tipo_id",
            ]
        );
        $this->assertDatabaseMissing(table: $this->class, data: $attr);
    }

    public function testEnvioInvalido(): void
    {
        $this->browse(
            callback: function (Browser $browser): void {
                $browser->visit(url: new Form(...$this->PARAMS));

                $browser
                    ->type(field: "@input-nombre", value: "sdh$%&")
                    ->type(field: "@input-matricula", value: "asadsfd/%%")
                    ->type(field: "@input-modelo", value: "modelo/1")
                    ->type(field: "@input-marca", value: "marca&1")
                    ->type(field: "@input-nro_serie", value: "serie5s4=")
                    ->press(button: "@submit");

                $browser
                    ->assertSeeIn(
                        selector: "@msg-nombre",
                        text: 'El nombre no debe contener: !, ", ·, %, /, \, =, +, -, *, [], {}.'
                    )
                    ->assertSeeIn(
                        selector: "@msg-matricula",
                        text: "La matrícula sólo debe contener: letras mayúsculas, números."
                    )
                    ->assertSeeIn(
                        selector: "@msg-nro_serie",
                        text: "El Nro. de Serie sólo debe contener: letras mayúsculas, números."
                    )
                    ->assertSeeIn(
                        selector: "@msg-marca",
                        text: "La marca no debe contener: caracteres especiales, números."
                    )
                    ->assertSeeIn(
                        selector: "@msg-modelo",
                        text: "El modelo no debe contener: caracteres especiales, números."
                    );

                $browser->assertRouteIs(
                    route: "maquina.edit",
                    parameters: [
                        $this->recurso => $this->row->id,
                    ]
                );
            }
        );
    }

    public function testEnvioValido(): void
    {
        $data = $this->class
            ::factory(
                count: 1,
                state: [
                    "tipo_id" => 1,
                    "cad_iteaf" => $this->row->cad_iteaf,
                ]
            )
            ->make()
            ->first();
        $this->browse(
            callback: function (Browser $browser) use ($data): void {
                $browser->visit(url: new Form(...$this->PARAMS));

                $browser
                    ->type(field: "@input-nombre", value: $data->nombre)
                    ->type(field: "@input-matricula", value: $data->matricula)
                    ->type(field: "@input-nro_serie", value: $data->nro_serie)
                    ->type(field: "@input-fabricante", value: $data->fabricante)
                    ->type(field: "@input-marca", value: $data->marca)
                    ->type(field: "@input-modelo", value: $data->modelo)
                    ->type(field: "@input-roma", value: $data->roma)
                    ->type(
                        field: "@txt-observaciones",
                        value: $data->observaciones
                    )
                    ->press(button: "@submit");

                $browser
                    ->pause(milliseconds: 1000)
                    ->assertRouteIs(
                        route: "maquina.show",
                        parameters: [$this->recurso => $this->row->id]
                    );
            }
        );

        $this->assertDatabaseHas(
            table: $this->class,
            data: ["id" => $this->row->id]
        );
        $this->assertDatabaseMissing(
            table: $this->class,
            data: Arr::except(
                array: $this->row->getAttributes(),
                keys: ["id", "created_at", "updated_at"]
            )
        );
        $this->assertDatabaseHas(
            table: $this->class,
            data: Arr::except(
                array: $data->getAttributes(),
                keys: ["id", "created_at", "updated_at"]
            )
        );
    }
}
