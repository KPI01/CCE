<?php

namespace Tests\Browser;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\Recursos\Form;
use Tests\DuskTestCase;

class CreatePersonaTest extends DuskTestCase
{
    public function testAcceso(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(recurso: "personas", accion: "create"));
        });
    }

    public function testAccesibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(recurso: "personas", accion: "create"))
                ->within(new Navbar(), function (Browser $browser) {
                    $browser
                        ->assertPresent("@titulo")
                        ->assertPresent("@nav")
                        ->assertPresent("@list")
                        ->assertPresent("@rcs-btn")
                        ->assertPresent("@conf-btn")
                        ->assertPresent("@home-btn");
                });

            $browser
                ->assertPresent("@form-create-persona")
                ->assertPresent("@label-nombres")
                ->assertPresent("@input-nombres")
                ->assertPresent("@label-apellidos")
                ->assertPresent("@input-apellidos")
                ->assertPresent("@label-id_nac")
                ->assertPresentByName("select", "tipo_id_nac")
                ->assertPresent("@input-id_nac")
                ->assertPresent("@label-email")
                ->assertPresent("@input-email")
                ->assertPresent("@label-tel")
                ->assertPresent("@input-tel")
                ->assertPresent("@label-perfil")
                ->assertPresent("@trigger-perfil")
                ->assertPresentByName("select", "perfil")
                ->assertPresent("@label-observaciones")
                ->assertPresent("@txt-observaciones")
                ->assertPresent("@switch")
                ->assertPresent("@submit");
        });
    }

    public function testAccesibilidadRopo(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(recurso: "personas", accion: "create"))
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
                ->visit(new Form(recurso: "personas", accion: "create"))
                ->within(new Navbar(), function (Browser $browser) {
                    $browser
                        ->assertVisible("@nav")
                        ->assertVisible("@list")
                        ->assertVisible("@rcs-btn")
                        ->assertVisible("@conf-btn")
                        ->assertVisible("@home-btn");
                });

            $browser
                ->assertVisible("@form-create-persona")
                ->assertVisible("@label-nombres")
                ->assertVisible("@input-nombres")
                ->assertVisible("@label-apellidos")
                ->assertVisible("@input-apellidos")
                ->assertVisible("@label-id_nac")
                ->assertVisibleByName("select", "tipo_id_nac")
                ->assertVisible("@input-id_nac")
                ->assertVisible("@label-email")
                ->assertVisible("@input-email")
                ->assertVisible("@label-tel")
                ->assertVisible("@input-tel")
                ->assertVisible("@label-perfil")
                ->assertVisible("@trigger-perfil")
                ->assertVisibleByName("select", "perfil")
                ->assertVisible("@label-observaciones")
                ->assertVisible("@txt-observaciones")
                ->assertVisible("@switch")
                ->assertVisible("@submit");

            $browser->screenshot("empresa/create/visibilidad");
        });
    }

    public function testCamposHabilitados(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(recurso: "personas", accion: "create"))
                ->assertEnabled("@input-nombres")
                ->assertEnabled("@input-apellidos")
                ->assertEnabled("@trigger-tipo_id_nac")
                ->assertEnabledByName("select", "tipo_id_nac")
                ->assertEnabled("@input-id_nac")
                ->assertEnabled("@input-email")
                ->assertEnabled("@input-tel")
                ->assertEnabled("@trigger-perfil")
                ->assertEnabledByName("select", "perfil")
                ->assertEnabled("@txt-observaciones")
                ->assertEnabled("@switch");
        });
    }

    public function testVisibilidadRopo(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(recurso: "personas", accion: "create"))
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

    public function testCamposHabilitadosRopo(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(recurso: "personas", accion: "create"))
                ->assertEnabled("@switch")
                ->click("@switch")
                ->pause(750)
                ->assertEnabled("@trigger-ropo_capacitacion")
                ->assertEnabledByName("select", "ropo.capacitacion")
                ->assertEnabled("@input-ropo_nro")
                ->assertEnabled("@trigger-ropo_caducidad");
        });
    }

    public function testCalendarioCaducidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(recurso: "personas", accion: "create"))
                ->assertEnabled("@switch")
                ->click("@switch")
                ->pause(750)
                ->assertEnabled("@trigger-ropo_caducidad")
                ->click("@trigger-ropo_caducidad")
                ->pause(1000)
                ->assertPresent("@calendar")
                ->assertVisible("@calendar");
        });
    }

    public function testLlenadoBasico(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(recurso: "personas", accion: "create"))
                ->type("@input-nombres", "window")
                ->assertInputValue("@input-nombres", "window")
                ->type("@input-apellidos", "window")
                ->assertInputValue("@input-apellidos", "window")
                ->assertSelectHasOptionByName("tipo_id_nac", "DNI")
                ->selectByName("tipo_id_nac", "DNI")
                ->assertSelectedByName("tipo_id_nac", "DNI")
                ->type("@input-id_nac", "window")
                ->assertInputValue("@input-id_nac", "window")
                ->type("@input-email", "window")
                ->assertInputValue("@input-email", "window")
                ->type("@input-tel", "window")
                ->assertInputValue("@input-tel", "window")
                ->assertSelectHasOptionByName("perfil", "Aplicador")
                ->selectByName("perfil", "Aplicador")
                ->assertSelectedByName("perfil", "Aplicador")
                ->type("@txt-observaciones", "window")
                ->assertInputValue("@txt-observaciones", "window");
        });
    }

    public function testLlenadoCompleto(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(recurso: "personas", accion: "create"))
                ->type("@input-nombres", "window")
                ->assertInputValue("@input-nombres", "window")
                ->type("@input-apellidos", "window")
                ->assertInputValue("@input-apellidos", "window")
                ->selectByName("tipo_id_nac", "DNI")
                ->assertSelectedByName("tipo_id_nac", "DNI")
                ->type("@input-id_nac", "window")
                ->assertInputValue("@input-id_nac", "window")
                ->type("@input-email", "window")
                ->assertInputValue("@input-email", "window")
                ->type("@input-tel", "window")
                ->assertInputValue("@input-tel", "window")
                ->selectByName("perfil", "Aplicador")
                ->assertSelectedByName("perfil", "Aplicador")
                ->type("@txt-observaciones", "window")
                ->assertInputValue("@txt-observaciones", "window");

            $browser
                ->click("@switch")
                ->pause(750)
                ->type("@input-ropo_nro", "window")
                ->assertInputValue("@input-ropo_nro", "window")
                ->selectByName("ropo.capacitacion", "Básico")
                ->assertSelectedByName("ropo.capacitacion", "Básico");
        });
    }

    public function testEnvioInvalidos(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(recurso: "personas", accion: "create"))
                ->type("@input-nombres", "at")
                ->type("@input-apellidos", "as")
                ->selectByName("tipo_id_nac", "DNI")
                ->type("@input-id_nac", "window")
                ->type("@input-email", "window.com")
                ->type("@input-tel", "123")
                ->type("@txt-observaciones", "window")
                ->press("@submit");

            $browser
                ->assertPresent("@msg-nombres")
                ->assertPresent("@msg-id_nac")
                ->assertPresent("@msg-email")
                ->assertPresent("@msg-tel");

            $browser
                ->assertVisible("@msg-nombres")
                ->assertVisible("@msg-id_nac")
                ->assertVisible("@msg-email")
                ->assertVisible("@msg-tel");
        });
    }

    public function testEnvioInvalidoConCorrecionInvalida(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(recurso: "personas", accion: "create"))
                ->type("@input-nombres", "at")
                ->type("@input-apellidos", "as")
                ->selectByName("tipo_id_nac", "DNI")
                ->type("@input-id_nac", "window")
                ->type("@input-email", "window.com")
                ->type("@input-tel", "123")
                ->type("@txt-observaciones", "window")
                ->press("@submit");

            $browser
                ->assertSeeIn(
                    "@msg-nombres",
                    "El nombre debe tener al menos 3 caracteres."
                )
                ->assertSeeIn(
                    "@msg-apellidos",
                    "El apellido debe tener al menos 3 caracteres."
                )
                ->assertSeeIn(
                    "@msg-id_nac",
                    "La identificación debe tener el formato adecuado."
                )
                ->assertSeeIn("@msg-email", "El correo debe ser válido.")
                ->assertSeeIn(
                    "@msg-tel",
                    "El número de teléfono debe ser válido."
                );

            $browser
                ->type("@input-nombres", "at123")
                ->type("@input-apellidos", "fa123")
                ->type("@input-id_nac", "fa123")
                ->type("@input-email", "window.com123")
                ->type("@input-tel", "123123")
                ->press("@submit");

            $browser
                ->assertSeeIn(
                    "@msg-nombres",
                    "El nombre solo puede contener letras."
                )
                ->assertSeeIn(
                    "@msg-id_nac",
                    "La identificación debe tener el formato adecuado."
                )
                ->assertSeeIn("@msg-email", "El correo debe ser válido.")
                ->assertSeeIn(
                    "@msg-tel",
                    "El número de teléfono debe ser válido."
                );
        });
    }

    public function testRopoInvalidos(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(recurso: "personas", accion: "create"))
                ->type("@input-nombres", "GODTIC SA")
                ->type("@input-apellidos", "W9120406E")
                ->selectByName("tipo_id_nac", "DNI")
                ->type("@input-id_nac", "W9120406E")
                ->type("@input-email", "m4upn217rk@email.com")
                ->type("@input-tel", "978726881")
                ->type(
                    "@txt-observaciones",
                    "Lorem ipsum dolor sit amet nulla et lorem elitr consequat nonumy et gubergren sadipscing lorem iusto et voluptua."
                );

            $browser
                ->click("@switch")
                ->pause(750)
                ->type("@input-ropo_nro", "123")
                ->press("@submit");

            $browser
                ->assertPresent("@msg-ropo_capacitacion")
                ->assertSeeIn(
                    "@msg-ropo_capacitacion",
                    "Debes ingresar una capacitación ROPO."
                );

            $browser
                ->selectByName("ropo.capacitacion", "Cualificado")
                ->type("@input-ropo_nro", " ")
                ->press("@submit");

            $browser
                ->assertPresent("@msg-ropo_nro")
                ->assertSeeIn(
                    "@msg-ropo_nro",
                    "La identificación ROPO debe estar en el formato adecuado."
                );
        });
    }

    public function testEnvioVacio(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(recurso: "personas", accion: "create"))
                ->press("@submit");

            $browser
                ->assertPresent("@msg-nombres")
                ->assertPresent("@msg-id_nac")
                ->assertPresent("@msg-email");
        });
    }

    public function testCreateExitoso(): void
    {
        $inst = Persona::where("email", "typ7kpw1cx@whoever.com")->first();
        DB::table("persona_ropo")->where("nro", "579265481842S")->delete();

        if (isset($inst)) {
            $inst->delete();
        }

        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(recurso: "personas", accion: "create"))
                ->type("@input-nombres", "Noa")
                ->type("@input-apellidos", "Morillo Pena")
                ->type("@input-id_nac", "05285485Q")
                ->type("@input-email", "typ7kpw1cx@whoever.com")
                ->type("@input-tel", "608001820")
                ->type(
                    "@txt-observaciones",
                    "Lorem ipsum dolor sit amet euismod ipsum sit eirmod ipsum voluptua invidunt lorem sed gubergren illum voluptua nulla takimata sed facilisi et voluptua. Vel ipsum no voluptua ut doming amet. Exerci amet takimata invidunt odio stet nonumy."
                )
                ->click("@switch")
                ->pause(750)
                ->selectByName("ropo.capacitacion", "Cualificado")
                ->type("@input-ropo_nro", "579265481842S")
                ->click("@trigger-ropo_caducidad")
                ->pause(750)
                ->click(
                    "@calendar table tbody tr:last-child td:last-child button"
                )
                ->pause(750)
                ->press("@submit");

            $browser
                ->pause(1000)
                ->assertPathIs("/app/recurso/personas")
                ->assertSee("se ha registrado exitosamente");
        });

        $this->assertDatabaseHas(
            Persona::class,
            ["email" => "typ7kpw1cx@whoever.com"],
            "mysql"
        );

        Persona::where("email", "typ7kpw1cx@whoever.com")->first()->delete();
    }
}
