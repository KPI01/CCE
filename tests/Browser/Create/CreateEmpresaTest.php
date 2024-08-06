<?php

namespace Tests\Browser\Create;

use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\Recursos\Form;
use Tests\DuskTestCase;

class CreateEmpresaTest extends DuskTestCase
{
    public function testAcceso(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(recurso: "empresas", accion: "create"));
        });
    }

    public function testAccesibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(recurso: "empresas", accion: "create"))
                ->within(new Navbar(), function (Browser $browser) {
                    $browser
                        ->assertPresent("@navbar")
                        ->assertPresent("@acc-home")
                        ->assertPresent("@acc-recursos")
                        ->assertPresent("@acc-config");
                });

            $browser
                ->assertPresent("@form-create-empresa")
                ->assertPresent("@label-nombre")
                ->assertPresent("@input-nombre")
                ->assertPresent("@label-nif")
                ->assertPresent("@input-nif")
                ->assertPresent("@label-email")
                ->assertPresent("@input-email")
                ->assertPresent("@label-tel")
                ->assertPresent("@input-tel")
                ->assertPresent("@label-codigo")
                ->assertPresent("@input-codigo")
                ->assertPresent("@label-perfil")
                ->assertPresent("@trigger-perfil")
                ->assertPresentByName("select", "perfil")
                ->assertPresent("@label-direccion")
                ->assertPresent("@txt-direccion")
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
                ->visit(new Form(recurso: "empresas", accion: "create"))
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
                ->visit(new Form(recurso: "empresas", accion: "create"))
                ->within(new Navbar(), function (Browser $browser) {
                    $browser
                        ->assertVisible("@navbar")
                        ->assertVisible("@acc-home")
                        ->assertVisible("@acc-recursos")
                        ->assertVisible("@acc-config");
                });

            $browser
                ->assertVisible("@form-create-empresa")
                ->assertVisible("@label-nombre")
                ->assertVisible("@input-nombre")
                ->assertVisible("@label-nif")
                ->assertVisible("@input-nif")
                ->assertVisible("@label-email")
                ->assertVisible("@input-email")
                ->assertVisible("@label-tel")
                ->assertVisible("@input-tel")
                ->assertVisible("@label-codigo")
                ->assertVisible("@input-codigo")
                ->assertVisible("@label-perfil")
                ->assertVisible("@trigger-perfil")
                ->assertVisibleByName("select", "perfil")
                ->assertVisible("@label-direccion")
                ->assertVisible("@txt-direccion")
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
                ->visit(new Form(recurso: "empresas", accion: "create"))
                ->assertEnabled("@input-nombre")
                ->assertEnabled("@input-nif")
                ->assertEnabled("@input-email")
                ->assertEnabled("@input-tel")
                ->assertEnabled("@input-codigo")
                ->assertEnabled("@trigger-perfil")
                ->assertEnabledByName("select", "perfil")
                ->assertEnabled("@txt-direccion")
                ->assertEnabled("@txt-observaciones")
                ->assertEnabled("@switch");
        });
    }

    public function testVisibilidadRopo(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(recurso: "empresas", accion: "create"))
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
                ->visit(new Form(recurso: "empresas", accion: "create"))
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
                ->visit(new Form(recurso: "empresas", accion: "create"))
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
                ->visit(new Form(recurso: "empresas", accion: "create"))
                ->type("@input-nombre", "window")
                ->assertInputValue("@input-nombre", "window")
                ->type("@input-nif", "window")
                ->assertInputValue("@input-nif", "window")
                ->type("@input-email", "window")
                ->assertInputValue("@input-email", "window")
                ->type("@input-tel", "window")
                ->assertInputValue("@input-tel", "window")
                ->type("@input-codigo", "window")
                ->assertInputValue("@input-codigo", "window")
                ->type("@txt-direccion", "window")
                ->assertSelectHasOptionByName("perfil", "Aplicador")
                ->selectByName("perfil", "Aplicador")
                ->assertSelectedByName("perfil", "Aplicador")
                ->assertInputValue("@txt-direccion", "window")
                ->type("@txt-observaciones", "window")
                ->assertInputValue("@txt-observaciones", "window");
        });
    }

    public function testLlenadoCompleto(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(recurso: "empresas", accion: "create"))
                ->type("@input-nombre", "window")
                ->assertInputValue("@input-nombre", "window")
                ->type("@input-nif", "window")
                ->assertInputValue("@input-nif", "window")
                ->type("@input-email", "window")
                ->assertInputValue("@input-email", "window")
                ->type("@input-tel", "window")
                ->assertInputValue("@input-tel", "window")
                ->type("@input-codigo", "window")
                ->assertInputValue("@input-codigo", "window")
                ->type("@txt-direccion", "window")
                ->selectByName("perfil", "Aplicador")
                ->assertSelectedByName("perfil", "Aplicador")
                ->assertInputValue("@txt-direccion", "window")
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
                ->visit(new Form(recurso: "empresas", accion: "create"))
                ->type("@input-nombre", "at")
                ->type("@input-nif", "as")
                ->type("@input-email", "window.com")
                ->type("@input-tel", "123")
                ->type("@input-codigo", "abc")
                ->type("@txt-direccion", "window")
                ->type("@txt-observaciones", "window")
                ->press("@submit");

            $browser
                ->assertPresent("@msg-nombre")
                ->assertPresent("@msg-nif")
                ->assertPresent("@msg-email")
                ->assertPresent("@msg-tel");

            $browser
                ->assertVisible("@msg-nombre")
                ->assertVisible("@msg-nif")
                ->assertVisible("@msg-email")
                ->assertVisible("@msg-tel");
        });
    }

    public function testEnvioInvalidoConCorrecionInvalida(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(recurso: "empresas", accion: "create"))
                ->type("@input-nombre", "at")
                ->type("@input-nif", "as")
                ->type("@input-email", "window.com")
                ->type("@input-tel", "123")
                ->type("@input-codigo", "abc")
                ->type("@txt-direccion", "window")
                ->type("@txt-observaciones", "window")
                ->press("@submit");

            $browser
                ->assertSeeIn(
                    "@msg-nombre",
                    "El nombre debe tener al menos 3 caracteres."
                )
                ->assertSeeIn("@msg-nif", "El NIF debe ser válido.")
                ->assertSeeIn("@msg-email", "El correo debe ser válido.")
                ->assertSeeIn(
                    "@msg-tel",
                    "El número de teléfono debe ser válido."
                );

            $browser
                ->type("@input-nombre", "at=)(")
                ->type("@input-nif", "fa123")
                ->type("@input-email", "window.com123")
                ->type("@input-tel", "123123")
                ->press("@submit");

            $browser
                ->assertSeeIn(
                    "@msg-nombre",
                    "El nombre solo puede contener letras, números, o (, . - · &)."
                )
                ->assertSeeIn("@msg-nif", "El NIF debe ser válido.")
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
                ->visit(new Form(recurso: "empresas", accion: "create"))
                ->type("@input-nombre", "GODTIC SA")
                ->type("@input-nif", "W9120406E")
                ->type("@input-email", "m4upn217rk@email.com")
                ->type("@input-tel", "978726881")
                ->type("@input-codigo", "489664")
                ->type("@txt-direccion", "PASEO IGLESIA, 38")
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
                    "Debes seleccionar una capacitación ROPO."
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
                ->visit(new Form(recurso: "empresas", accion: "create"))
                ->press("@submit");

            $browser
                ->assertPresent("@msg-nombre")
                ->assertPresent("@msg-nif")
                ->assertPresent("@msg-email");
        });
    }

    public function testCreateExitoso(): void
    {
        $inst = Empresa::where("email", "m4upn217rk@email.com")->first();
        DB::table("empresa_ropo")->where("nro", "595731818842S")->delete();

        if (isset($inst)) {
            $inst->delete();
        }

        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Form(recurso: "empresas", accion: "create"))
                ->type("@input-nombre", "GODTIC SA")
                ->type("@input-nif", "W9120406E")
                ->type("@input-email", "m4upn217rk@email.com")
                ->type("@input-tel", "978726881")
                ->type("@input-codigo", "489664")
                ->type("@txt-direccion", "PASEO IGLESIA, 38")
                ->type(
                    "@txt-observaciones",
                    "Lorem ipsum dolor sit amet nulla et lorem elitr consequat nonumy et gubergren sadipscing lorem iusto et voluptua."
                )
                ->click("@switch")
                ->pause(750)
                ->selectByName("ropo.capacitacion", "Cualificado")
                ->type("@input-ropo_nro", "595731818842S")
                ->click("@trigger-ropo_caducidad")
                ->pause(750)
                ->click(
                    "@calendar table tbody tr:last-child td:last-child button"
                )
                ->pause(750)
                ->press("@submit");

            $browser
                ->pause(1000)
                ->assertPathIs("/app/recurso/empresas")
                ->assertSee("se ha registrado exitosamente");
        });

        $this->assertDatabaseHas(
            Empresa::class,
            ["email" => "m4upn217rk@email.com"],
            "mysql"
        );

        Empresa::where("email", "m4upn217rk@email.com")->first()->delete();
    }
}
