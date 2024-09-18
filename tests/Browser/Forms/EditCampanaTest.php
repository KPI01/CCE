<?php

namespace Tests\Browser\Forms;

use App\Models\Campana;
use Illuminate\Support\Arr;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Recursos\Form;
use Tests\RecursoDuskTestCase;

class EditCampanaTest extends RecursoDuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->hasDeleteBtn = true;
        $this->class = Campana::class;
        $this->recurso = "campana";
        $this->row = Campana::factory(count: 1)->create()->first();
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
                    ->assertPresent(selector: "@label-is_activa")
                    ->assertPresent(selector: "@label-inicio")
                    ->assertPresent(selector: "@label-fin")
                    ->assertPresent(selector: "@label-descripcion");

                $browser
                    ->assertPresent(selector: "@input-nombre")
                    ->assertPresent(selector: "@switch-is_activa")
                    ->assertPresent(selector: "@trigger-inicio")
                    ->assertPresent(selector: "@input-inicio")
                    ->assertPresent(selector: "@trigger-fin")
                    ->assertPresent(selector: "@input-fin")
                    ->assertPresent(selector: "@txt-descripcion");
            }
        );
    }

    public function testVisibilidad(): void
    {
        parent::testVisibilidad();
        $this->browse(
            callback: function (Browser $browser): void {
                $browser->visit(url: new Form(...$this->PARAMS));

                $browser
                    ->assertVisible(selector: "@breadcrumb")
                    ->assertVisible(selector: "@title")
                    ->assertVisible(selector: "@form-edit-{$this->row->id}")
                    ->assertVisible(selector: "@badge-createdAt")
                    ->assertVisible(selector: "@badge-updatedAt");

                $browser
                    ->assertVisible(selector: "@label-nombre")
                    ->assertVisible(selector: "@label-is_activa")
                    ->assertVisible(selector: "@label-inicio")
                    ->assertVisible(selector: "@label-fin")
                    ->assertVisible(selector: "@label-descripcion");

                $browser
                    ->assertVisible(selector: "@input-nombre")
                    ->assertVisible(selector: "@switch-is_activa")
                    ->assertVisible(selector: "@trigger-inicio")
                    ->assertVisible(selector: "@trigger-fin")
                    ->assertVisible(selector: "@txt-descripcion");
            }
        );
    }

    public function testCamposHabilitados(): void
    {
        $this->browse(
            callback: function (Browser $browser): void {
                $browser->visit(url: new Form(...$this->PARAMS));

                $browser
                    ->assertEnabled(field: "@input-nombre")
                    ->assertEnabled(field: "@trigger-inicio")
                    ->assertEnabled(field: "@trigger-fin")
                    ->assertEnabled(field: "@txt-descripcion");
            }
        );
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
                    ->assertAriaAttribute(
                        selector: "@switch-is_activa",
                        attribute: "checked",
                        value: $this->row->is_activa ? "true" : "false"
                    )
                    ->assertSeeIn(
                        selector: "@trigger-inicio",
                        text: $this->row->inicio->format("d/m/Y")
                    )
                    ->assertInputValue(
                        field: "@trigger-inicio",
                        value: $this->row->inicio->format("d/m/Y")
                    )
                    ->assertSeeIn(
                        selector: "@trigger-fin",
                        text: $this->row->fin->format("d/m/Y")
                    )
                    ->assertInputValue(
                        field: "@trigger-fin",
                        value: $this->row->fin->format("d/m/Y")
                    )
                    ->assertInputValue(
                        field: "@txt-descripcion",
                        value: $this->row->descripcion
                    );
            }
        );
    }

    public function testEnvioRequeridosVacio(): void
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

                $browser
                    ->press(button: "@submit")
                    ->assertSeeIn(
                        selector: "@msg-nombre",
                        text: "El nombre es requerido"
                    );
            }
        );
    }

    public function testCamposVaciados(): void
    {
        $this->browse(
            callback: function (Browser $browser): void {
                $browser->visit(url: new Form(...$this->PARAMS));

                for (
                    $i = 0;
                    $i < strlen(string: $this->row->descripcion);
                    $i++
                ) {
                    $browser->keys(
                        selector: "@txt-descripcion",
                        keys: "{backspace}"
                    );
                }
                $browser->assertInputValue(
                    field: "@txt-descripcion",
                    value: ""
                );

                $browser
                    ->press(button: "@submit")
                    ->pause(milliseconds: 1000)
                    ->assertRouteIs(
                        route: "campana.show",
                        parameters: [$this->recurso => $this->row->id]
                    );
            }
        );

        $attr = Arr::except(
            array: $this->row->getAttributes(),
            keys: ["descripcion", "updated_at"]
        );
        $this->assertDatabaseHas(table: $this->class, data: $attr);

        $attr = Arr::only(
            array: $this->row->getAttributes(),
            keys: ["descripcion"]
        );
        $this->assertDatabaseMissing(table: $this->class, data: $attr);
    }

    public function testEnvioInvalido(): void
    {
        $this->browse(
            callback: function (Browser $browser): void {
                $browser->visit(url: new Form(...$this->PARAMS));

                $browser->type(field: "@input-nombre", value: "12345&%$");

                $browser
                    ->press(button: "@submit")
                    ->assertSeeIn(
                        selector: "@msg-nombre",
                        text: "El nombre no debe contener: caracteres especiales"
                    );

                $browser->assertRouteIs(
                    route: "campana.edit",
                    parameters: [
                        $this->recurso => $this->row->id,
                    ]
                );
            }
        );
    }

    public function testEnvioValido(): void
    {
        $data = $this->class::factory(count: 1)->make()->first();

        $this->browse(
            callback: function (Browser $browser) use ($data): void {
                $browser->visit(url: new Form(...$this->PARAMS));

                $browser
                    ->type(field: "@input-nombre", value: $data->nombre)
                    ->click(selector: "@trigger-inicio")
                    ->pause(milliseconds: 500)
                    ->click(
                        selector: "@calendar-inicio table tbody tr:nth-last-child(2) td:last-child"
                    )
                    ->click(selector: "@trigger-fin")
                    ->pause(milliseconds: 500)
                    ->click(
                        selector: "@calendar-fin table tbody tr:nth-last-child(2) td:last-child"
                    );
            }
        );
    }
}
