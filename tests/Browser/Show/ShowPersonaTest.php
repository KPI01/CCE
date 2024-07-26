<?php

namespace Tests\Browser\Show;

use App\Models\Persona;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\Recursos\Form;
use Tests\DuskTestCase;

class ShowPersonaTest extends DuskTestCase
{
    public Persona $p;

    public function setUp(): void
    {
        parent::setUp();
        $this->p = Persona::factory(1)->withRopo()->create()->first();
    }

    public function testAcceso(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(
                new Form(recurso: "personas", accion: "show", id: $this->p->id)
            );
        });
    }

    public function testAccesibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(
                new Form(recurso: "personas", accion: "show", id: $this->p->id)
            );

            $browser->within(new Navbar(), function ($browser) {
                $browser
                    ->assertPresent("@nav")
                    ->assertPresent("@list")
                    ->assertPresent("@rcs-btn")
                    ->assertPresent("@conf-btn")
                    ->assertPresent("@home-btn");
            });

            $id = $this->p->id;
            $browser
                ->assertPresent("@badge-destroy-$id")
                ->assertPresent("@badge-edit-$id")
                ->assertPresent("@badge-created-$id")
                ->assertPresent("@badge-updated-$id")
                ->assertPresent("@form-show-$id")
                ->assertPresent("h1")
                ->assertPresent("@h3-basicos")
                ->assertPresent("@h3-ropo")
                ->assertPresent("@separator")
                ->assertPresentByName("select", "tipo_id_nac")
                ->assertPresent("@label-id_nac")
                ->assertPresent("@input-id_nac")
                ->assertPresent("@label-email")
                ->assertPresent("@input-email")
                ->assertPresent("@label-tel")
                ->assertPresent("@input-tel")
                ->assertPresent("@label-perfil")
                ->assertPresent("@trigger-perfil")
                ->assertPresentByName("select", "perfil")
                ->assertPresent("@label-observaciones")
                ->assertPresent("@txt-observaciones");

            $browser
                ->assertPresent("@label-ropo_capacitacion")
                ->assertPresent("@trigger-ropo_capacitacion")
                ->assertPresentByName("select", "ropo.capacitacion")
                ->assertPresent("@label-ropo_nro")
                ->assertPresent("@input-ropo_nro")
                ->assertPresent("@label-ropo_caducidad")
                ->assertPresent("@input-ropo_caducidad")
                ->assertPresent("@trigger-ropo_caducidad");

            $browser->screenshot("persona/show/accesibilidad");
        });
    }

    public function testVisibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(
                new Form(recurso: "personas", accion: "show", id: $this->p->id)
            );

            $browser->within(new Navbar(), function ($browser) {
                $browser
                    ->assertVisible("@nav")
                    ->assertVisible("@list")
                    ->assertVisible("@rcs-btn")
                    ->assertVisible("@conf-btn")
                    ->assertVisible("@home-btn");
            });

            $browser
                ->assertVisible("@badge-destroy-" . $this->p->id)
                ->assertVisible("@badge-edit-" . $this->p->id)
                ->assertVisible("@badge-created-" . $this->p->id)
                ->assertVisible("@badge-updated-" . $this->p->id)
                ->assertVisible("@form-show-" . $this->p->id)
                ->assertVisible("h1")
                ->assertSeeIn(
                    "h1",
                    $this->p->nombres . " " . $this->p->apellidos
                )
                ->assertVisible("@h3-basicos")
                ->assertVisible("@h3-ropo")
                ->assertVisible("@separator")
                ->assertVisibleByName("select", "tipo_id_nac")
                ->assertVisible("@label-id_nac")
                ->assertVisible("@input-id_nac")
                ->assertVisible("@label-email")
                ->assertVisible("@input-email")
                ->assertVisible("@label-tel")
                ->assertVisible("@input-tel")
                ->assertVisible("@label-perfil")
                ->assertVisible("@trigger-perfil")
                ->assertVisibleByName("select", "perfil")
                ->assertVisible("@label-observaciones")
                ->assertVisible("@txt-observaciones");

            $browser
                ->assertVisible("@label-ropo_capacitacion")
                ->assertVisible("@trigger-ropo_capacitacion")
                ->assertVisibleByName("select", "ropo.capacitacion")
                ->assertVisible("@label-ropo_nro")
                ->assertVisible("@input-ropo_nro")
                ->assertVisible("@label-ropo_caducidad")
                ->assertVisible("@trigger-ropo_caducidad");

            $browser->screenshot("persona/show/visibilidad");
        });
    }

    public function testValorCampos(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(
                    new Form(
                        recurso: "personas",
                        accion: "show",
                        id: $this->p->id
                    )
                )
                ->assertInputValue(
                    "h1",
                    $this->p->nombres . " " . $this->p->apellidos
                )
                ->assertSelectedByName("tipo_id_nac", $this->p->tipo_id_nac)
                ->assertInputValue("@input-id_nac", $this->p->id_nac)
                ->assertInputValue("@input-email", $this->p->email)
                ->assertInputValue("@input-tel", $this->p->tel)
                ->assertSelectedByName("perfil", $this->p->perfil)
                ->assertInputValue(
                    "@txt-observaciones",
                    $this->p->observaciones
                )
                ->assertInputValue(
                    "@txt-observaciones",
                    $this->p->observaciones
                );

            $browser
                ->assertSelectedByName(
                    "ropo.capacitacion",
                    $this->p->ropo["capacitacion"]
                )
                ->assertInputValue("@input-ropo_nro", $this->p->ropo["nro"])
                ->assertInputValue(
                    "@input-ropo_caducidad",
                    $this->p->ropo["caducidad"]
                );

            $browser->screenshot("persona/show/valores");
        });
    }

    public function testCamposInhabilitados(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(
                    new Form(
                        recurso: "personas",
                        accion: "show",
                        id: $this->p->id
                    )
                )
                ->assertDisabled("@trigger-tipo_id_nac")
                ->assertDisabled("@input-id_nac")
                ->assertDisabled("@input-email")
                ->assertDisabled("@input-tel")
                ->assertDisabled("@trigger-perfil")
                ->assertDisabled("@txt-observaciones")
                ->assertDisabled("@trigger-ropo_capacitacion")
                ->assertDisabled("@input-ropo_nro")
                ->assertDisabled("@trigger-ropo_caducidad");
        });
    }

    public function testBadges(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(
                    new Form(
                        recurso: "personas",
                        accion: "show",
                        id: $this->p->id
                    )
                )
                ->assertSeeIn(
                    selector: "@badge-created-" . $this->p->id,
                    text: date("d/m/Y, H:i:s", strtotime($this->p->created_at)),
                    ignoreCase: true
                )
                ->assertSeeIn(
                    selector: "@badge-updated-" . $this->p->id,
                    text: date("d/m/Y, H:i:s", strtotime($this->p->updated_at)),
                    ignoreCase: true
                );

            $browser
                ->assertEnabled("@badge-edit-" . $this->p->id)
                ->click("@badge-edit-" . $this->p->id)
                ->pause(1750)
                ->assertPathIs(
                    "/app/recurso/personas/" . $this->p->id . "/edit"
                );

            $browser
                ->visit(
                    new Form(
                        recurso: "personas",
                        accion: "show",
                        id: $this->p->id
                    )
                )
                ->click("@badge-destroy-" . $this->p->id)
                ->pause(750)
                ->assertVisible("@alertdialog")
                ->assertVisible("#alert-title")
                ->assertVisible("#alert-footer")
                ->assertVisible("#alert-cancel")
                ->assertVisible("#alert-confirm")
                ->click("#alert-cancel")
                ->pause(750)
                ->assertPathIs("/app/recurso/personas/" . $this->p->id)
                ->click("@badge-destroy-" . $this->p->id)
                ->pause(750)
                ->click("#alert-confirm")
                ->pause(750)
                ->assertPathIs("/app/recurso/personas");
        });
    }

    public function testRegreso(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(
                    new Form(
                        recurso: "personas",
                        accion: "show",
                        id: $this->p->id
                    )
                )
                ->click("@back-btn")
                ->pause(750)
                ->assertPathIs("/app/recurso/personas");
        });
    }

    public function testAcciones(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(
                    new Form(
                        recurso: "personas",
                        accion: "show",
                        id: $this->p->id
                    )
                )
                ->assertSeeIn(
                    selector: "@badge-created-" . $this->p->id,
                    text: date("d/m/Y, H:i:s", strtotime($this->p->created_at)),
                    ignoreCase: true
                )
                ->assertSeeIn(
                    selector: "@badge-updated-" . $this->p->id,
                    text: date("d/m/Y, H:i:s", strtotime($this->p->updated_at)),
                    ignoreCase: true
                );

            $browser
                ->assertEnabled("@badge-edit-" . $this->p->id)
                ->click("@badge-edit-" . $this->p->id)
                ->pause(1750)
                ->assertPathIs(
                    "/app/recurso/personas/" . $this->p->id . "/edit"
                );

            $browser
                ->visit(
                    new Form(
                        recurso: "personas",
                        accion: "show",
                        id: $this->p->id
                    )
                )
                ->click("@badge-destroy-" . $this->p->id)
                ->pause(750)
                ->assertVisible("@alertdialog")
                ->assertVisible("#alert-title")
                ->assertVisible("#alert-footer")
                ->assertVisible("#alert-cancel")
                ->assertVisible("#alert-confirm")
                ->click("#alert-cancel")
                ->pause(750)
                ->assertPathIs("/app/recurso/personas/" . $this->p->id)
                ->click("@badge-destroy-" . $this->p->id)
                ->pause(750)
                ->click("#alert-confirm")
                ->pause(750)
                ->assertPathIs("/app/recurso/personas");
        });

        $this->assertDatabaseMissing("personas", [
            "id" => $this->p->id,
        ]);
    }
}
