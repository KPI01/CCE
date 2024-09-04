<?php

namespace Tests\Browser\Forms;

use App\Models\Maquina;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\Recursos\Form;
use Tests\RecursoDuskTestCase;

class CreateMaquinaTest extends RecursoDuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->PARAMS = ["maquina", "create"];
    }

    public function testAcceso(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));
        });
    }

    public function testAccesibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser->within(new Navbar(), function (Browser $browser) {
                $browser
                    ->assertPresent("@navbar")
                    ->assertPresent("@acc-home")
                    ->assertPresent("@acc-recursos")
                    ->assertPresent("@acc-config");
            });

            $browser
                ->assertPresent("@breadcrumb")
                ->assertPresent("@title")
                ->assertPresent("@form-create-maquina");

            $browser
                ->assertPresent("@label-nombre")
                ->assertPresent("@label-matricula")
                ->assertPresent("@label-tipo")
                ->assertPresent("@label-fabricante")
                ->assertPresent("@label-modelo")
                ->assertPresent("@label-marca")
                ->assertPresent("@label-roma")
                ->assertPresent("@label-nro_serie")
                ->assertPresent("@label-cad_iteaf")
                ->assertPresent("@label-observaciones");

            $browser
                ->assertPresent("@input-nombre")
                ->assertPresent("@input-matricula")
                ->assertPresent("@trigger-tipo")
                ->assertPresentByName("select", "tipo")
                ->assertPresent("@input-fabricante")
                ->assertPresent("@input-modelo")
                ->assertPresent("@input-marca")
                ->assertPresent("@input-roma")
                ->assertPresent("@input-nro_serie")
                ->assertPresent("@input-cad_iteaf")
                ->assertPresent("@txt-observaciones");

            $browser->assertPresent("@submit");
        });
    }

    public function testVisibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser->within(new Navbar(), function (Browser $browser) {
                $browser
                    ->assertVisible("@navbar")
                    ->assertVisible("@acc-home")
                    ->assertVisible("@acc-recursos")
                    ->assertVisible("@acc-config");
            });

            $browser
                ->assertVisible("@breadcrumb")
                ->assertVisible("@title")
                ->assertSeeIn("@title", "Máquina")
                ->assertVisible("@form-create-maquina");

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

            $browser->assertVisible("@submit")->assertEnabled("@submit");
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
                ->assertEnabled("@input-matricula")
                ->assertInputValue("@input-matricula", "")
                ->type("@input-matricula", "test")
                ->assertInputValue("@input-matricula", "test");

            $browser
                ->assertEnabled("@trigger-tipo")
                ->assertEnabledByName("select", "tipo")
                ->click("@trigger-tipo")
                ->pause(500)
                ->assertPresent("@sel-options")
                ->assertPresent("@sel-option:first-of-type")
                ->assertVisible("@sel-options")
                ->assertVisible("@sel-option:first-of-type")
                ->click("@sel-option:first-of-type")
                ->assertSeeIn("@trigger-tipo > span", "Pulverizador");

            $browser
                ->assertEnabled("@input-fabricante")
                ->assertInputValue("@input-fabricante", "")
                ->type("@input-fabricante", "test")
                ->assertInputValue("@input-fabricante", "test");

            $browser
                ->assertEnabled("@input-modelo")
                ->assertInputValue("@input-modelo", "")
                ->type("@input-modelo", "test")
                ->assertInputValue("@input-modelo", "test");

            $browser
                ->assertEnabled("@input-marca")
                ->assertInputValue("@input-marca", "")
                ->type("@input-marca", "test")
                ->assertInputValue("@input-marca", "test");

            $browser
                ->assertEnabled("@input-roma")
                ->assertInputValue("@input-roma", "")
                ->type("@input-roma", "test")
                ->assertInputValue("@input-roma", "test");

            $browser
                ->assertEnabled("@input-nro_serie")
                ->assertInputValue("@input-nro_serie", "")
                ->type("@input-nro_serie", "test")
                ->assertInputValue("@input-nro_serie", "test");

            $browser->assertEnabled("@trigger-cad_iteaf");
            /** PENDIENTE: desarrollo test a date picker */

            $browser
                ->assertEnabled("@txt-observaciones")
                ->assertInputValue("@txt-observaciones", "")
                ->type("@txt-observaciones", "test")
                ->assertInputValue("@txt-observaciones", "test");
        });
    }

    public function testEnvioVacio(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser->press("@submit")->pause(500);

            $browser
                ->assertPresent("@msg-nombre")
                ->assertPresent("@msg-matricula");

            $browser
                ->assertVisible("@msg-nombre")
                ->assertVisible("@msg-matricula");

            $browser
                ->assertSeeIn("@msg-nombre", "El nombre es requerido.")
                ->assertSeeIn("@msg-matricula", "La matrícula es requerida.");
        });
    }

    public function testEnvioInvalido(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->type("@input-nombre", "ab")
                ->type("@input-matricula", "abc")
                ->click("@trigger-tipo")
                ->pause(500)
                ->click("@sel-option:first-of-type")
                ->press("@submit");

            $browser
                ->assertPresent("@msg-nombre")
                ->assertPresent("@msg-matricula")
                ->assertVisible("@msg-nombre")
                ->assertVisible("@msg-matricula")
                ->assertSeeIn(
                    "@msg-nombre",
                    "Este campo debe tener al menos 3 caracteres"
                )
                ->assertSeeIn(
                    "@msg-matricula",
                    "Este campo debe tener al menos 8 caracteres"
                );

            $browser
                ->type("@input-nombre", "maquina123%$()")
                ->assertSeeIn(
                    "@msg-nombre",
                    'El nombre no debe contener: !, ", ·, %, /, \, =, +, -, *, [], {}.'
                )
                ->type("@input-matricula", "abcsdfsdfs")
                ->assertSeeIn(
                    "@msg-matricula",
                    "La matrícula sólo debe contener: letras mayúsculas, números."
                );

            /** Opcionales */

            $browser
                ->type("@input-nro_serie", "abd()$%")
                ->assertPresent("@msg-nro_serie")
                ->assertVisible("@msg-nro_serie")
                ->assertSeeIn(
                    "@msg-nro_serie",
                    "El Nro. de Serie sólo debe contener: letras mayúsculas, números."
                );
            $browser
                ->type("@input-modelo", "abd()$%")
                ->assertPresent("@msg-modelo")
                ->assertVisible("@msg-modelo")
                ->assertSeeIn(
                    "@msg-modelo",
                    "El modelo no debe contener: caracteres especiales, números."
                );

            $browser
                ->type("@input-marca", "abd()$%")
                ->assertPresent("@msg-marca")
                ->assertVisible("@msg-marca")
                ->assertSeeIn(
                    "@msg-marca",
                    "La marca no debe contener: caracteres especiales, números."
                );
        });
    }

    public function testEnvioValido(): void
    {
        $data = Maquina::factory(1, ["tipo_id" => 1, "cad_iteaf" => null])
            ->make()
            ->first();

        $this->browse(function (Browser $browser) use ($data) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->type("@input-nombre", $data->nombre)
                ->type("@input-matricula", $data->matricula)
                ->type("@input-fabricante", $data->fabricante)
                ->type("@input-modelo", $data->modelo)
                ->type("@input-marca", $data->marca)
                ->type("@input-roma", $data->roma)
                ->type("@input-nro_serie", $data->nro_serie)
                ->type("@txt-observaciones", $data->observaciones);

            $browser
                ->press("@submit")
                ->pause(5000)
                ->assertRouteIs("maquina.index");
        });

        $attr = $data->getAttributes();
        unset($attr["id"]);

        $this->assertDatabaseHas(Maquina::class, $attr);
    }
}
