<?php

namespace Tests\Browser\Edit;

use App\Models\Persona;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\Recursos\Persona\Edit;
use Tests\DuskTestCase;

class EditPersonaTest extends DuskTestCase
{
    public Persona $p;

    public function setUp(): void
    {
        parent::setUp();
        $this->p = Persona::factory(1)->withRopo()->create()->first();
    }

    public function testAcceso(): void
    {
        //
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Edit($this->p))
                ->responsiveScreenshots("persona/edit/acceso");
        });
    }

    public function testAccesibilidad(): void
    {
        //
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Edit($this->p))
                ->assertPresent("@form")
                ->assertPresent("@separator")
                ->assertPresent("@h3-datos_personales")
                ->assertPresent("@h3-ropo")
                ->assertPresent("@label-nombres")
                ->assertPresent("@input-nombres")
                ->assertPresent("@label-apellidos")
                ->assertPresent("@input-apellidos")
                ->assertPresent("@label-id_nac")
                ->assertPresent("@trigger-tipo_id_nac")
                ->assertPresent("@input-id_nac")
                ->assertPresent("@label-email")
                ->assertPresent("@input-email")
                ->assertPresent("@label-tel")
                ->assertPresent("@input-tel")
                ->assertPresent("@label-perfil")
                ->assertPresent("@trigger-perfil")
                ->assertPresent("@label-observaciones")
                ->assertPresent("@txt-observaciones")
                ->assertPresent("@label-ropo_tipo")
                ->assertPresent("@trigger-ropo_tipo")
                ->assertPresent("@label-ropo_nro")
                ->assertPresent("@input-ropo_nro")
                ->assertPresent("@label-ropo_caducidad")
                ->assertPresent("@trigger-ropo_caducidad")
                ->assertPresent("@input-ropo_caducidad")
                ->assertPresent("@label-ropo_tipo_aplicador")
                ->assertPresent("@trigger-ropo_tipo_aplicador")
                ->assertPresentByName("select", "tipo_id_nac")
                ->assertPresentByName("select", "perfil")
                ->assertPresentByName("select", "ropo.tipo")
                ->assertPresentByName("select", "ropo.tipo_aplicador")
                ->within(new Navbar(), function (Browser $browser) {
                    $browser
                        ->assertPresent("@titulo")
                        ->assertPresent("@home-btn")
                        ->assertPresent("@conf-btn")
                        ->assertPresent("@nav")
                        ->assertPresent("@list")
                        ->assertPresent("@rsrc-btn");
                });

            $browser
                ->assertVisible("@form")
                ->assertVisible("@separator")
                ->assertVisible("@h3-datos_personales")
                ->assertVisible("@h3-ropo")
                ->assertVisible("@label-nombres")
                ->assertVisible("@input-nombres")
                ->assertVisible("@label-apellidos")
                ->assertVisible("@input-apellidos")
                ->assertVisible("@label-id_nac")
                ->assertVisible("@trigger-tipo_id_nac")
                ->assertVisible("@input-id_nac")
                ->assertVisible("@label-email")
                ->assertVisible("@input-email")
                ->assertVisible("@label-tel")
                ->assertVisible("@input-tel")
                ->assertVisible("@label-perfil")
                ->assertVisible("@trigger-perfil")
                ->assertVisible("@label-observaciones")
                ->assertVisible("@txt-observaciones")
                ->assertVisible("@label-ropo_tipo")
                ->assertVisible("@trigger-ropo_tipo")
                ->assertVisible("@label-ropo_nro")
                ->assertVisible("@input-ropo_nro")
                ->assertVisible("@label-ropo_caducidad")
                ->assertVisible("@trigger-ropo_caducidad")
                ->assertVisible("@label-ropo_tipo_aplicador")
                ->assertVisible("@trigger-ropo_tipo_aplicador")
                ->assertVisibleByName("select", "tipo_id_nac")
                ->assertVisibleByName("select", "perfil")
                ->assertVisibleByName("select", "ropo.tipo")
                ->assertVisibleByName("select", "ropo.tipo_aplicador")
                ->within(new Navbar(), function (Browser $browser) {
                    $userNombre = $this->user->nombres;
                    $browser
                        ->assertSeeIn("@titulo", "Bienvenido, $userNombre")
                        ->assertVisible("@home-btn")
                        ->assertVisible("@conf-btn")
                        ->assertVisible("@nav")
                        ->assertVisible("@list")
                        ->assertVisible("@rsrc-btn");
                });

            $browser
                ->assertEnabled("@input-nombres")
                ->assertEnabled("@input-apellidos")
                ->assertButtonEnabled("@trigger-tipo_id_nac")
                ->assertEnabledByName("select", "tipo_id_nac")
                ->assertEnabled("@input-id_nac")
                ->assertEnabled("@input-email")
                ->assertEnabled("@input-tel")
                ->assertButtonEnabled("@trigger-perfil")
                ->assertEnabledByName("select", "perfil")
                ->assertEnabled("@txt-observaciones")
                ->assertButtonEnabled("@trigger-ropo_tipo")
                ->assertEnabledByName("select", "ropo.tipo")
                ->assertEnabled("@input-ropo_nro")
                ->assertButtonEnabled("@trigger-ropo_caducidad")
                ->assertButtonEnabled("@trigger-ropo_tipo_aplicador")
                ->assertEnabledByName("select", "ropo.tipo_aplicador");

            $browser->responsiveScreenshots("persona/edit/accesibilidad");
        });
    }

    public function testValorDeCampos(): void
    {
        //
        $this->browse(function (Browser $browser) {
            $browser->visit(new Edit($this->p));

            $browser
                ->assertValue("@input-nombres", $this->p->nombres)
                ->assertValue("@input-apellidos", $this->p->apellidos)
                ->assertSelectedByName("tipo_id_nac", $this->p->tipo_id_nac)
                ->assertValue("@input-id_nac", $this->p->id_nac)
                ->assertValue("@input-email", $this->p->email)
                ->assertValue("@input-tel", $this->p->tel)
                ->assertSelectedByName("perfil", $this->p->perfil);

            if ($this->p->ropo) {
                // dd($this->p->ropo);
                $i = $this->p->ropo;
                $browser
                    ->assertValue("@input-ropo_nro", $i["nro"])
                    ->assertValue("@input-ropo_caducidad", $i["caducidad"])
                    ->assertSelectedByName("ropo.tipo", $i["tipo"])
                    ->assertSelectedByName(
                        "ropo.tipo_aplicador",
                        $i["tipo_aplicador"]
                    );
            }

            $browser->responsiveScreenshots("persona/edit/valor_de_campos");
        });
    }

    public function testEnvioVacio(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Edit($this->p));

            $browser
                ->type("@input-nombres", " ")
                ->type("@input-apellidos", " ")
                ->type("@input-id_nac", " ")
                ->type("@input-email", " ")
                ->press("@submit");

            $browser
                ->assertSeeIn(
                    "@msg-nombres",
                    "El nombre debe tener al menos 3 caracteres."
                )
                ->assertSeeIn(
                    "@msg-apellidos",
                    "Los apellidos deben tener al menos 3 caracteres."
                )
                ->assertSeeIn(
                    "@msg-id_nac",
                    "La identificación debe tener el formato adecuado."
                )
                ->assertSeeIn("@msg-email", "El correo debe ser válido.");

            $browser->responsiveScreenshots("persona/edit/envio_vacio");
        });
    }

    public function testEnvioInvalido(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Edit($this->p));

            $browser
                ->type("@input-nombres", "Et")
                ->type("@input-apellidos", "ex")
                ->assertSelectMissingOptionByName("tipo_id_nac", ["NIF", "VAT"])
                ->assertSelectHasOptionByName("tipo_id_nac", ["DNI", "NIE"])
                ->type("@input-id_nac", "dolore")
                ->type("@input-email", "minim")
                ->type("@input-tel", "takimata")
                ->press("@submit");

            $browser
                ->assertSeeIn(
                    "@msg-nombres",
                    "El nombre debe tener al menos 3 caracteres."
                )
                ->assertSeeIn(
                    "@msg-apellidos",
                    "Los apellidos deben tener al menos 3 caracteres."
                )
                ->assertSeeIn(
                    "@msg-id_nac",
                    "La identificación debe tener el formato adecuado."
                )
                ->assertSeeIn("@msg-email", "El correo debe ser válido.")
                ->assertSeeIn(
                    "@msg-tel",
                    "El número debe estar en el formato indicado."
                );

            $browser->responsiveScreenshots(
                "persona/edit/envio_requeridos_invalido"
            );
        });
    }

    public function testEnvioBasicosValidoRopoInvalido(): void
    {
        $data = [
            "nombres" => "consequat",
            "apellidos" => "adipiscing",
            "tipo_id_nac" => "DNI",
            "id_nac" => "52378265C",
            "email" => "ghastly@dom.com",
            "tel" => "123-45-67-89",
            "perfil" => "Supervisor",
            "observaciones" =>
                "door aptly though sitting that fiend within longer raven sure",
            "ropo" => [
                "tipo" => "Técnico",
                "nro" => "12346",
            ],
        ];

        $this->browse(function (Browser $browser) use ($data) {
            $browser->visit(new Edit($this->p));
            $browser
                ->type("@input-nombres", $data["nombres"])
                ->type("@input-apellidos", $data["apellidos"])
                ->selectByName("tipo_id_nac", $data["tipo_id_nac"])
                ->type("@input-id_nac", $data["id_nac"])
                ->type("@input-email", $data["email"])
                ->type("@input-tel", $data["tel"])
                ->selectByName("perfil", $data["perfil"])
                ->type("@txt-observaciones", $data["observaciones"])
                ->selectByName("ropo.tipo", $data["ropo"]["tipo"])
                ->type("@input-ropo_nro", $data["ropo"]["nro"])
                ->press("@submit");

            $browser
                ->assertNotPresent("@msg-nombres")
                ->assertNotPresent("@msg-apellidos")
                ->assertNotPresent("@msg-id_nac")
                ->assertNotPresent("@msg-email")
                ->assertNotPresent("@msg-tel")
                ->assertPresent("@msg-ropo_nro")
                ->assertSeeIn(
                    "@msg-ropo_nro",
                    "El Nº del carnet debe estar en el formato adecuado."
                );

            $browser->responsiveScreenshots(
                "persona/edit/envio_requeridos_invalido"
            );
        });
    }

    public function testEnvioCorrecto(): void
    {
        $data = [
            "nombres" => "Omar",
            "apellidos" => "Gutierrez",
            "tipo_id_nac" => "NIE",
            "id_nac" => "Z1564278X",
            "email" => "nmenchaca@example.org",
            "tel" => "296-72-88-22",
            "perfil" => "Supervisor",
            "observaciones" =>
                "door aptly though sitting that fiend within longer raven sure",
            "ropo" => [
                "tipo" => "Aplicador",
                "nro" => "296/4",
                "caducidad" => "2027-05-29",
                "tipo_aplicador" => "Básico",
            ],
        ];

        $this->browse(function (Browser $browser) use ($data) {
            $browser->visit(new Edit($this->p));

            $browser
                ->type("@input-nombres", $data["nombres"])
                ->type("@input-apellidos", $data["apellidos"])
                ->selectByName("tipo_id_nac", $data["tipo_id_nac"])
                ->type("@input-id_nac", $data["id_nac"])
                ->type("@input-email", $data["email"])
                ->type("@input-tel", $data["tel"])
                ->selectByName("perfil", $data["perfil"])
                ->type("@txt-observaciones", $data["observaciones"])
                ->selectByName("ropo.tipo", $data["ropo"]["tipo"])
                ->type("@input-ropo_nro", $data["ropo"]["nro"])
                ->click("@trigger-ropo_caducidad")
                ->pause(500)
                ->click("@calendar table tr:nth-child(3) td:nth-child(3)")
                ->selectByName(
                    "ropo.tipo_aplicador",
                    $data["ropo"]["tipo_aplicador"]
                )
                ->press("@submit")
                ->pause(1000);

            $browser
                ->assertNotPresent("@msg-nombres")
                ->assertNotPresent("@msg-apellidos")
                ->assertNotPresent("@msg-id_nac")
                ->assertNotPresent("@msg-email")
                ->assertNotPresent("@msg-tel")
                ->assertNotPresent("@msg-ropo_nro")
                ->assertNotPresent("@msg-ropo_caducidad");

            $browser
                ->responsiveScreenshots("persona/edit/envio_correcto")
                ->assertRouteIs("personas.index");
        });
    }

    public function testEnvioSinCambios(): void
    {
        $this->p->setRopoAttribute([
            ...$this->p->getRopoAttribute(),
            "nro" => "296/4",
        ]);
        $this->p->save();

        $this->browse(function (Browser $browser) {
            $browser->visit(new Edit($this->p));

            $browser->press("@submit")->pause(750);

            $browser
                ->assertPresent("ol li#edit-sin_cambios")
                ->responsiveScreenshots("persona/edit/envio_sin_cambios");
        });
    }
}
