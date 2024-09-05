<?php

namespace Tests\Browser\Forms;

use App\Models\Persona;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Recursos\Form;
use Tests\RecursoDuskTestCase;

class CreatePersonaTest extends RecursoDuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->PARAMS = ["persona", "create"];
    }
    public function testAcceso(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));
        });
    }

    public function testAccesibilidad(): void
    {
        parent::testAccesibilidad();
        $this->browse(function (Browser $browser) {
            $browser
                ->assertPresent("@breadcrumb")
                ->assertPresent("@title")
                ->assertPresent("@form-create-persona");

            $browser
                ->assertPresent("@label-nombres")
                ->assertPresent("@label-apellidos")
                ->assertPresent("@label-id_nac")
                ->assertPresent("@label-email")
                ->assertPresent("@label-tel")
                ->assertPresent("@label-perfil")
                ->assertPresent("@label-observaciones");

            $browser
                ->assertPresent("@input-nombres")
                ->assertPresent("@input-apellidos")
                ->assertPresentByName("select", "tipo_id_nac")
                ->assertPresent("@input-id_nac")
                ->assertPresent("@input-email")
                ->assertPresent("@input-tel")
                ->assertPresent("@trigger-perfil")
                ->assertPresentByName("select", "perfil")
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
                ->assertSeeIn("@title", "Persona")
                ->assertVisible("@form-create-persona");

            $browser
                ->assertVisible("@label-nombres")
                ->assertVisible("@label-apellidos")
                ->assertVisible("@label-id_nac")
                ->assertVisible("@label-email")
                ->assertVisible("@label-tel")
                ->assertVisible("@label-perfil")
                ->assertVisible("@label-observaciones");

            $browser
                ->assertVisible("@input-nombres")
                ->assertVisible("@input-apellidos")
                ->assertVisibleByName("select", "tipo_id_nac")
                ->assertVisible("@input-id_nac")
                ->assertVisible("@input-email")
                ->assertVisible("@input-tel")
                ->assertVisible("@trigger-perfil")
                ->assertVisibleByName("select", "perfil")
                ->assertVisible("@txt-observaciones");

            $browser->assertPresent("@submit")->assertEnabled("@submit");

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
                ->assertEnabled("@input-nombres")
                ->assertInputValue("@input-nombres", "")
                ->type("@input-nombres", "test")
                ->assertInputValue("@input-nombres", "test");

            $browser
                ->assertEnabled("@input-apellidos")
                ->assertInputValue("@input-apellidos", "")
                ->type("@input-apellidos", "test")
                ->assertInputValue("@input-apellidos", "test");

            $browser
                ->assertEnabled("@trigger-tipo_id_nac")
                ->assertEnabledByName("select", "tipo_id_nac")
                ->click("@trigger-tipo_id_nac")
                ->pause(500)
                ->assertPresent("@sel-options")
                ->assertPresent("@sel-option:first-of-type")
                ->assertVisible("@sel-options")
                ->assertVisible("@sel-option:first-of-type")
                ->click("@sel-option:first-of-type")
                ->assertSeeIn("@trigger-tipo_id_nac > span", "DNI");

            $browser
                ->assertEnabled("@input-id_nac")
                ->assertInputValue("@input-id_nac", "")
                ->type("@input-id_nac", "test")
                ->assertInputValue("@input-id_nac", "test");

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
                ->assertEnabled("@trigger-perfil")
                ->assertEnabledByName("select", "perfil")
                ->click("@trigger-tipo_id_nac")
                ->pause(500)
                ->assertPresent("@sel-options")
                ->assertPresent("@sel-option:first-of-type")
                ->assertVisible("@sel-options")
                ->assertVisible("@sel-option:first-of-type")
                ->click("@sel-option:first-of-type")
                ->assertSeeIn("@trigger-perfil > span", "Productor");

            $browser
                ->assertEnabled("@txt-observaciones")
                ->assertInputValue("@txt-observaciones", "")
                ->type("@txt-observaciones", "test")
                ->assertInputValue("@txt-observaciones", "test");

            $browser
                ->click("@switch")
                ->pause(500)
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
                ->assertPresent("@msg-nombres")
                ->assertPresent("@msg-apellidos")
                ->assertPresent("@msg-id_nac")
                ->assertPresent("@msg-email");

            $browser
                ->assertVisible("@msg-nombres")
                ->assertVisible("@msg-apellidos")
                ->assertVisible("@msg-id_nac")
                ->assertVisible("@msg-email");

            $browser
                ->assertSeeIn("@msg-nombres", "El nombre es requerido.")
                ->assertSeeIn("@msg-apellidos", "El apellido es requerido.")
                ->assertSeeIn("@msg-id_nac", "La identificación es requerida.")
                ->assertSeeIn("@msg-email", "El correo es requerido");
        });
    }

    public function testEnvioInvalido(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->type("@input-nombres", "at")
                ->type("@input-apellidos", "as")
                ->type("@input-id_nac", "window")
                ->type("@input-email", "window.com")
                ->type("@input-tel", "123")
                ->press("@submit");

            $browser
                ->assertPresent("@msg-nombres")
                ->assertPresent("@msg-apellidos")
                ->assertPresent("@msg-id_nac")
                ->assertPresent("@msg-email")
                ->assertPresent("@msg-tel")
                ->assertVisible("@msg-nombres")
                ->assertVisible("@msg-apellidos")
                ->assertVisible("@msg-id_nac")
                ->assertVisible("@msg-email")
                ->assertVisible("@msg-tel")
                ->assertSeeIn(
                    "@msg-nombres",
                    "Este campo debe tener al menos 3 caracteres."
                )
                ->assertSeeIn(
                    "@msg-apellidos",
                    "Este campo debe tener al menos 3 caracteres."
                )
                ->assertSeeIn(
                    "@msg-id_nac",
                    "La identificación debe ser válida."
                )
                ->assertSeeIn("@msg-email", "El correo debe ser válido");

            $browser
                ->type("@input-nombres", "nombre&%12")
                ->assertSeeIn(
                    "@msg-nombres",
                    "El nombre sólo debe contener: letras."
                );

            $browser
                ->type("@input-apellidos", "apellido&%12")
                ->assertSeeIn(
                    "@msg-apellidos",
                    "El apellido sólo debe contener: letras."
                );

            $browser
                ->type("@input-id_nac", "267&%")
                ->assertSeeIn(
                    "@msg-id_nac",
                    "La identificación debe ser válida."
                );

            $browser
                ->type("@input-email", "window@")
                ->assertSeeIn("@msg-email", "El correo debe ser válido.");

            /** Opcionales */

            $browser
                ->type("@input-tel", "123456789")
                ->assertPresent("@msg-tel")
                ->assertVisible("@msg-tel")
                ->assertSeeIn("@msg-tel", "El teléfono debe ser válido.")
                ->type("@input-tel", "abc$%")
                ->assertSeeIn("@msg-tel", "El teléfono debe ser válido");

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
        $data = Persona::factory(1, [
            "tipo_id_nac" => "DNI",
            "id_nac" => fake()->dni(),
            "perfil" => "Productor",
        ])
            ->withRopo()
            ->make()
            ->first();

        $this->browse(function (Browser $browser) use ($data) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->type("@input-nombres", $data->nombres)
                ->type("@input-apellidos", $data->apellidos)
                ->type("@input-id_nac", $data->id_nac)
                ->type("@input-email", $data->email)
                ->type("@input-tel", $data->tel)
                ->type("@txt-observaciones", $data->observaciones);
            /** PENDIENTE: Implementar test a atributos ROPO */

            $browser
                ->press("@submit")
                ->pause(5000)
                ->assertRouteIs("persona.index");
        });

        $attr = $data->getAttributes();
        unset($attr["id"]);

        $this->assertDatabaseHas(Persona::class, $attr);
    }
}
