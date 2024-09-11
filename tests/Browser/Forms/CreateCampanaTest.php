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
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->assertPresent("@breadcrumb")
                ->assertPresent("@title")
                ->assertPresent("@form-create-campaña");

            $browser
                ->assertPresent("@label-nombre")
                ->assertPresent("@label-is_activa")
                ->assertPresent("@label-inicio")
                ->assertPresent("@label-fin")
                ->assertPresent("@label-descripcion");

            $browser
                ->assertPresent("@input-nombre")
                ->assertPresent("@switch-is_activa")
                ->assertPresent("@trigger-inicio")
                ->assertPresent("@input-inicio")
                ->assertPresent("@trigger-fin")
                ->assertPresent("@input-fin")
                ->assertPresent("@txt-descripcion");
        });
    }

    public function testVisibilidad(): void
    {
        parent::testVisibilidad();
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->assertVisible("@breadcrumb")
                ->assertVisible("@title")
                ->assertSeeIn("@title", "Campaña")
                ->assertVisible("@form-create-campaña");

            $browser
                ->assertVisible("@label-nombre")
                ->assertVisible("@label-is_activa")
                ->assertVisible("@label-inicio")
                ->assertVisible("@label-fin")
                ->assertVisible("@label-descripcion");

            $browser
                ->assertVisible("@input-nombre")
                ->assertVisible("@switch-is_activa")
                ->assertVisible("@trigger-inicio")
                ->assertVisible("@trigger-fin")
                ->assertVisible("@txt-descripcion");
        });
    }

    public function testCamposHabilitados(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->assertEnabled("@input-nombre")
                ->assertInputValue("@input-nombre", "")
                ->type("@input-nombre", "test")
                ->assertInputValue("@input-nombre", "test");

            $browser
                ->assertEnabled("@switch-is_activa")
                ->assertAriaAttribute("@switch-is_activa", "checked", "false")
                ->click("@switch-is_activa")
                ->pause(500)
                ->assertAriaAttribute("@switch-is_activa", "checked", "true");

            $browser->assertEnabled("@trigger-inicio");
            /** PENDIENTE: desarrollo test a date picker */

            $browser->assertEnabled("@trigger-fin");
            /** PENDIENTE: desarrollo test a date picker */

            $browser
                ->assertEnabled("@txt-descripcion")
                ->assertInputValue("@txt-descripcion", "")
                ->type("@txt-descripcion", "test")
                ->assertInputValue("@txt-descripcion", "test");
        });
    }
    public function testEnvioVacio(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser->press("@submit")->pause(500);

            $browser
                ->assertPresent("@msg-nombre")
                ->assertPresent("@msg-inicio")
                ->assertPresent("@msg-fin");

            $browser
                ->assertVisible("@msg-nombre")
                ->assertVisible("@msg-inicio")
                ->assertVisible("@msg-fin");

            $browser
                ->assertSeeIn("@msg-nombre", "El nombre es requerido.")
                ->assertSeeIn("@msg-inicio", "La fecha de inicio es requerida.")
                ->assertSeeIn("@msg-fin", "La fecha final es requerida.");
        });
    }

    public function testEnvioInvalido(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->type("@input-nombre", "abc%$%")
                ->pause(500)
                ->press("@submit");

            $browser
                ->assertPresent("@msg-nombre")
                ->assertVisible("@msg-nombre")
                ->assertSeeIn("@msg-nombre", "El nombre debe ser válido");
        });
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
