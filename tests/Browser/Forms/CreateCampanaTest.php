<?php

namespace Tests\Browser\Create;

use App\Models\Campana;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Recursos\Form;
use Tests\RecursoDuskTestCase;

class CreateCampanaTest extends RecursoDuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->PARAMS = ["campana", "create"];
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
                    ->assertPresent(selector: "@form-create-campaña");

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
                    ->assertSeeIn(selector: "@title", text: "Campaña")
                    ->assertVisible(selector: "@form-create-campaña");

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
                    ->assertInputValue(field: "@input-nombre", value: "")
                    ->type(field: "@input-nombre", value: "test")
                    ->assertInputValue(field: "@input-nombre", value: "test");

                $browser
                    ->assertEnabled(field: "@switch-is_activa")
                    ->assertAriaAttribute(
                        selector: "@switch-is_activa",
                        attribute: "checked",
                        value: "false"
                    )
                    ->click(selector: "@switch-is_activa")
                    ->pause(milliseconds: 500)
                    ->assertAriaAttribute(
                        selector: "@switch-is_activa",
                        attribute: "checked",
                        value: "true"
                    );

                $browser->assertEnabled(field: "@trigger-inicio");
                /** PENDIENTE: desarrollo test a date picker */

                $browser->assertEnabled(field: "@trigger-fin");
                /** PENDIENTE: desarrollo test a date picker */

                $browser
                    ->assertEnabled(field: "@txt-descripcion")
                    ->assertInputValue(field: "@txt-descripcion", value: "")
                    ->type(field: "@txt-descripvalue: cion", value: "test")
                    ->assertInputValue(
                        field: "@txt-descripcion",
                        value: "test"
                    );
            }
        );
    }
    public function testEnvioVacio(): void
    {
        $this->browse(
            callback: function (Browser $browser): void {
                $browser->visit(url: new Form(...$this->PARAMS));

                $browser->press(button: "@submit")->pause(milliseconds: 500);

                $browser
                    ->assertPresent(selector: "@msg-nombre")
                    ->assertPresent(selector: "@msg-inicio")
                    ->assertPresent(selector: "@msg-fin");

                $browser
                    ->assertVisible(selector: "@msg-nombre")
                    ->assertVisible(selector: "@msg-inicio")
                    ->assertVisible(selector: "@msg-fin");

                $browser
                    ->assertSeeIn(
                        selector: "@msg-nombre",
                        text: "El nombre es requerido."
                    )
                    ->assertSeeIn(
                        selector: "@msg-inicio",
                        text: "La fecha de inicio es requerida."
                    )
                    ->assertSeeIn(
                        selector: "@msg-fin",
                        text: "La fecha final es requerida."
                    );
            }
        );
    }

    public function testEnvioInvalido(): void
    {
        $this->browse(
            callback: function (Browser $browser): void {
                $browser->visit(url: new Form(...$this->PARAMS));

                $browser
                    ->type(field: "@input-nombre", value: "abc%$%")
                    ->pause(milliseconds: 500)
                    ->press(button: "@submit");

                $browser
                    ->assertPresent(selector: "@msg-nombre")
                    ->assertVisible(selector: "@msg-nombre")
                    ->assertSeeIn(
                        selector: "@msg-nombre",
                        text: "El nombre debe ser válido"
                    );
            }
        );
    }

    public function testEnvioValido(): void
    {
        $data = Campana::factory(1)->make()->first();

        $this->browse(function (Browser $browser) use ($data) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->type("@input-nombre", $data->nombre)
                ->click("@switch")
                ->pause(500)
                ->click("@trigger-inicio")
                ->pause(500)
                ->click(
                    "@calendar-inicio table tbody tr:nth-last-child(2) td:first-child"
                )
                ->pause(500)
                ->click("@trigger-fin")
                ->pause(500)
                ->click(
                    "@calendar-fin table tbody tr:nth-last-child(2) td:last-child"
                )
                ->type("@txt-descripcion", $data->descripcion);

            $browser
                ->press("@submit")
                ->pause(5000)
                ->assertRouteIs("campana.index");
        });

        $attr = $data->getAttributes();
        unset($attr["id"], $attr["inicio"], $attr["fin"]);

        $this->assertDatabaseHas(Campana::class, $attr);
    }
}
