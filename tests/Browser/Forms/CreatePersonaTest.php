<?php

namespace Tests\Browser\Forms;

use App\Models\Persona;
use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\Recursos\Form;
use Tests\DuskTestCase;

class CreatePersonaTest extends DuskTestCase
{
    const PARAMS = ["persona", "create"];
    public function testAcceso(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...self::PARAMS));
        });
    }

    public function testAccesibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(...self::PARAMS))
                ->within(new Navbar(), function (Browser $browser) {
                    $browser
                        ->assertPresent("@navbar")
                        ->assertPresent("@acc-home")
                        ->assertPresent("@acc-recursos")
                        ->assertPresent("@acc-config");
                });

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

            $browser->assertPresent("@switch")->assertPresent("@submit");
        });
    }

    public function testAccesibilidadRopo(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(...self::PARAMS))
                ->assertPresent("@switch")
                ->click("@switch")
                ->pause(750)
                ->assertPresent("#ropo-form")
                ->assertPresent("@label-ropo_capacitacion")
                ->assertPresent("@trigger-ropo_capacitacion")
                ->assertPresentByName("select", "ropo.capacitacion")
                ->assertPresent("@label-ropo_nro")
                ->assertPresent("@input-ropo_nro")
                ->assertPresent("@label-ropo_caducidad")
                ->assertPresent("@trigger-ropo_caducidad");
        });
    }

    public function testVisibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(...self::PARAMS))
                ->within(new Navbar(), function (Browser $browser) {
                    $browser
                        ->assertVisible("@navbar")
                        ->assertVisible("@acc-home")
                        ->assertVisible("@acc-recursos")
                        ->assertVisible("@acc-config");
                });

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

            $browser
                ->assertVisible("@switch")
                ->assertEnabled("@switch")
                ->assertPresent("@submit")
                ->assertEnabled("@submit");
        });
    }

    public function testVisibilidadRopo(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(...self::PARAMS))
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
            $browser->visit(new Form(...self::PARAMS));

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
        });
    }

    public function testCamposHabilitadosRopo(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(...self::PARAMS))
                ->assertEnabled("@switch")
                ->click("@switch")
                ->pause(750);

            $browser
                ->assertEnabled("@trigger-ropo_capacitacion")
                ->assertEnabledByName("select", "ropo.capacitacion")
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
            $browser->visit(new Form(...self::PARAMS));

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
            $browser->visit(new Form(...self::PARAMS));

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
                    "La identificación debe tener el formato adecuado."
                )
                ->assertSeeIn("@msg-email", "El correo debe ser válido");

            $browser
                ->type("@input-nombres", "nombre&%12")
                ->assertSeeIn(
                    "@msg-nombres",
                    "El nombre solo puede contener letras"
                );

            $browser
                ->type("@input-apellidos", "apellido&%12")
                ->assertSeeIn(
                    "@msg-apellidos",
                    "El apellido solo puede contener letras"
                );

            $browser
                ->type("@input-id_nac", "267&%")
                ->assertSeeIn(
                    "@msg-id_nac",
                    "La identificación debe tener el formato adecuado."
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
        });
    }

    public function testEnvioRopoInvalido(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...self::PARAMS));

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
                    "La identificación ROPO debe estar en el formato adecuado."
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
            $browser->visit(new Form(...self::PARAMS));

            $browser
                ->type("@input-nombres", $data->nombres)
                ->type("@input-apellidos", $data->apellidos)
                ->type("@input-id_nac", $data->id_nac)
                ->type("@input-email", $data->email)
                ->type("@input-tel", $data->tel)
                ->type("@txt-observaciones", $data->observaciones);

            $browser->screenshot("envio-valido");
            $browser
                ->press("@submit")
                ->pause(5000)
                ->assertRouteIs("persona.index");
            $browser->screenshot("envio-valido-1");
        });

        $attr = $data->getAttributes();
        unset($attr["id"]);

        $this->assertDatabaseHas(Persona::class, $attr);
    }
}
