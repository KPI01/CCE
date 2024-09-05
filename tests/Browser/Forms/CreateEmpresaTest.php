<?php

namespace Tests\Browser\Forms;

use App\Models\Empresa;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Recursos\Form;
use Tests\RecursoDuskTestCase;

class CreateEmpresaTest extends RecursoDuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->PARAMS = ["empresa", "create"];
    }

    public function testAccesibilidad(): void
    {
        parent::testAccesibilidad();
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->assertPresent("@breadcrumb")
                ->assertPresent("@title")
                ->assertPresent("@form-create-empresa");

            $browser
                ->assertPresent("@label-nombre")
                ->assertPresent("@label-nif")
                ->assertPresent("@label-email")
                ->assertPresent("@label-tel")
                ->assertPresent("@label-codigo")
                ->assertPresent("@label-perfil")
                ->assertPresent("@label-direccion")
                ->assertPresent("@label-observaciones");

            $browser
                ->assertPresent("@input-nombre")
                ->assertPresent("@input-nif")
                ->assertPresent("@input-email")
                ->assertPresent("@input-tel")
                ->assertPresent("@input-codigo")
                ->assertPresent("@trigger-perfil")
                ->assertPresentByName("select", "perfil")
                ->assertPresent("@txt-direccion")
                ->assertPresent("@txt-observaciones");

            $browser->assertPresent("@submit");

            $browser
                ->assertPresent("@switch")
                ->click("@switch")
                ->pause(750)
                ->assertPresent("#ropo-form")
                ->assertPresent("@label-ropo_capacitacion")
                ->assertPresent("@trigger-ropo_capacitacion")
                ->assertPresentByName("select", '"ropo.capacitacion"')
                ->assertPresent("@label-ropo_nro")
                ->assertPresent("@input-ropo_nro")
                ->assertPresent("@label-ropo_caducidad")
                ->assertPresent("@trigger-ropo_caducidad");
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
                ->assertSeeIn("@title", "Empresa")
                ->assertVisible("@form-create-empresa");

            $browser
                ->assertVisible("@label-nombre")
                ->assertVisible("@label-nif")
                ->assertVisible("@label-email")
                ->assertVisible("@label-tel")
                ->assertVisible("@label-codigo")
                ->assertVisible("@label-perfil")
                ->assertVisible("@label-direccion")
                ->assertVisible("@label-observaciones");

            $browser
                ->assertVisible("@input-nombre")
                ->assertVisible("@input-nif")
                ->assertVisible("@input-email")
                ->assertVisible("@input-tel")
                ->assertVisible("@input-codigo")
                ->assertVisible("@trigger-perfil")
                ->assertVisibleByName("select", "perfil")
                ->assertVisible("@txt-direccion")
                ->assertVisible("@txt-observaciones");

            $browser
                ->assertVisible("@switch")
                ->assertEnabled("@switch")
                ->assert("@submit")
                ->assertEnabled("@submit");

            $browser
                ->assertEnabled("@switch")
                ->click("@switch")
                ->pause(750)
                ->assertVisible("#ropo-form")
                ->assertVisible("@label-ropo_capacitacion")
                ->assertVisible("@trigger-ropo_capacitacion")
                ->assertVisible("@label-ropo_nro")
                ->assertVisible("@input-ropo_nro")
                ->assertVisible("@label-ropo_caducidad")
                ->assertVisible("@trigger-ropo_caducidad");
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
                ->assertEnabled("@input-nif")
                ->assertInputValue("@input-nif", "")
                ->type("@input-nif", "test")
                ->assertInputValue("@input-nif", "test");

            $browser
                ->assertEnabled("@input-email")
                ->assertInputValue("@input-email", "")
                ->type("@input-email", "test")
                ->assertInputValue("@input-email", "test");

            $browser
                ->assertEnabled("@input-tel")
                ->assertInputValue("@input-tel", "")
                ->type("@input-tel", "test")
                ->assertInputValue("@input-tel", "test");

            $browser
                ->assertEnabled("@input-codigo")
                ->assertInputValue("@input-codigo", "")
                ->type("@input-codigo", "test")
                ->assertInputValue("@input-codigo", "test");

            $browser
                ->assertEnabled("@trigger-perfil")
                ->assertEnabledByName("select", "perfil")
                ->click("@trigger-perfil")
                ->pause(500)
                ->assertPresent("@sel-options")
                ->assertPresent("@sel-option:first-of-type")
                ->assertVisible("@sel-options")
                ->assertVisible("@sel-option:first-of-type")
                ->click("@sel-option:first-of-type")
                ->assertSeeIn("@trigger-perfil > span", "Productor");

            $browser
                ->assertEnabled("@txt-direccion")
                ->assertInputValue("@txt-direccion", "")
                ->type("@txt-direccion", "test")
                ->assertInputValue("@txt-direccion", "test");

            $browser
                ->assertEnabled("@txt-observaciones")
                ->assertInputValue("@txt-observaciones", "")
                ->type("@txt-observaciones", "test")
                ->assertInputValue("@txt-observaciones", "test");

            $browser->assertEnabled("@switch")->click("@switch")->pause(750);

            $browser
                ->assertEnabled("@trigger-ropo_capacitacion")
                ->assertEnabledByName("select", '"ropo.capacitacion"')
                ->click("@trigger-ropo_capacitacion")
                ->pause(500)
                ->assertPresent("@sel-options")
                ->assertPresent("@sel-option:first-of-type")
                ->assertVisible("@sel-options")
                ->assertVisible("@sel-option:first-of-type")
                ->click("@sel-option:first-of-type")
                ->assertSeeIn("@trigger-ropo_capacitacion > span", "Básico");

            $browser
                ->assertEnabled("@input-ropo_nro")
                ->assertInputValue("@input-ropo_nro", "")
                ->type("@input-ropo_nro", "test")
                ->assertInputValue("@input-ropo_nro", "test");

            $browser->assertEnabled("@trigger-ropo_caducidad");
            /** PENDIENTE: desarrollo test a date picker */
        });
    }

    public function testEnvioVacio(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser->press("@submit")->pause(500);

            $browser
                ->assertPresent("@msg-nombre")
                ->assertPresent("@msg-nif")
                ->assertPresent("@msg-email");

            $browser
                ->assertVisible("@msg-nombre")
                ->assertVisible("@msg-nif")
                ->assertVisible("@msg-email");

            $browser
                ->assertSeeIn("@msg-nombre", "El nombre es requerido.")
                ->assertSeeIn("@msg-nif", "El NIF es requerido.")
                ->assertSeeIn("@msg-email", "El correo es requerido");
        });
    }

    public function testEnvioInvalido(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->type("@input-nombre", "ac")
                ->type("@input-nif", "zxc")
                ->type("@input-email", "corr.com")
                ->press("@submit");

            $browser
                ->assertPresent("@msg-nombre")
                ->assertPresent("@msg-nif")
                ->assertPresent("@msg-email")
                ->assertVisible("@msg-nombre")
                ->assertVisible("@msg-nif")
                ->assertVisible("@msg-email")
                ->assertSeeIn(
                    "@msg-nombre",
                    "Este campo debe tener al menos 3 caracteres."
                )
                ->assertSeeIn("@msg-nif", "El NIF debe ser válido.")
                ->assertSeeIn("@msg-email", "El correo debe ser válido.");

            $browser
                ->type("@input-nombre", "askdjh$")
                ->assertSeeIn(
                    "@msg-nombre",
                    "El nombre sólo debe contener: letras, números, (), ., -, ·, &."
                );

            $browser
                ->type("@input-nif", "123456465Z")
                ->assertSeeIn("@msg-nif", "El NIF debe ser válido");

            $browser
                ->type("@input-email", "correo@")
                ->assertSeeIn("@msg-email", "El correo debe ser válido");

            /** Opcionales */

            $browser
                ->type("@input-tel", "123456789")
                ->assertPresent("@msg-tel")
                ->assertVisible("@msg-tel")
                ->assertSeeIn("@msg-tel", "El teléfono debe ser válido.");

            $browser
                ->type("@input-codigo", "abcdef")
                ->assertPresent("@msg-codigo")
                ->assertVisible("@msg-codigo")
                ->assertSeeIn(
                    "@msg-codigo",
                    "El código sólo debe contener: números."
                );

            $browser
                ->click("@switch")
                ->pause(750)
                ->type("@input-ropo_nro", "123")
                ->press("@submit");

            $browser
                ->assertPresent("@msg-ropo_capacitacion")
                ->assertVisible("@msg-ropo_capacitacion")
                ->assertSeeIn(
                    "@msg-ropo_capacitacion",
                    "La capacitación ROPO es requerida."
                );

            $browser
                ->assertPresent("@msg-ropo_nro")
                ->assertSeeIn(
                    "@msg-ropo_nro",
                    "La identificación ROPO debe ser válida."
                );
        });
    }

    public function testEnvioValido(): void
    {
        $data = Empresa::factory(1, [
            "perfil" => "Productor",
        ])
            ->withRopo()
            ->make()
            ->first();

        $this->browse(function (Browser $browser) use ($data): void {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->type("@input-nombre", $data->nombre)
                ->type("@input-nif", $data->nif)
                ->type("@input-email", $data->email)
                ->type("@input-tel", $data->tel)
                ->type("@input-codigo", $data->codigo)
                ->type("@txt-direccion", $data->direccion)
                ->type("@txt-observaciones", $data->observaciones);
            /** PENDIENTE: Implementar test a atributos ROPO  */

            $browser
                ->press("@submit")
                ->pause(5000)
                ->assertRouteIs("empresa.index");
        });

        $attr = $data->getAttributes();
        unset($attr["id"]);

        $this->assertDatabaseHas(Empresa::class, $attr);
    }
}
