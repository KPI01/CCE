<?php

namespace Tests\Browser\Show;

use App\Models\Empresa;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\Recursos\Form;
use Tests\DuskTestCase;

class ShowEmpresaTest extends DuskTestCase
{
    protected Empresa $e;

    public function setUp(): void
    {
        parent::setUp();
        $this->e = Empresa::factory(1)->withRopo()->create()->first();
    }

    public function testAcceso(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(
                new Form(recurso: "empresas", accion: "show", id: $this->e->id)
            );
        });
    }

    public function testAccesibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(
                    new Form(
                        recurso: "empresas",
                        accion: "show",
                        id: $this->e->id
                    )
                )
                ->within(new Navbar(), function ($browser) {
                    $browser
                        ->assertPresent("@navbar")
                        ->assertPresent("@acc-home")
                        ->assertPresent("@acc-recursos")
                        ->assertPresent("@acc-config");
                });
            $id = $this->e->id;
            $browser
                ->assertPresent("@badge-destroy-$id")
                ->assertPresent("@badge-edit-$id")
                ->assertPresent("@badge-created-$id")
                ->assertPresent("@badge-updated-$id")
                ->assertPresent("@form-show-$id")
                ->assertPresent("h1")
                ->assertPresent("@h3-general")
                ->assertPresent("@h3-ropo")
                ->assertPresent("@separator")
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

            $browser->screenshot("empresa/show/accesibilidad");
        });
    }

    public function testVisibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(
                    new Form(
                        recurso: "empresas",
                        accion: "show",
                        id: $this->e->id
                    )
                )
                ->within(new Navbar(), function ($browser) {
                    $browser
                        ->assertVisible("@navbar")
                        ->assertVisible("@acc-home")
                        ->assertVisible("@acc-recursos")
                        ->assertVisible("@acc-config");
                });

            $browser
                ->assertVisible("@badge-destroy-" . $this->e->id)
                ->assertVisible("@badge-edit-" . $this->e->id)
                ->assertVisible("@badge-created-" . $this->e->id)
                ->assertVisible("@badge-updated-" . $this->e->id)
                ->assertVisible("@form-show-" . $this->e->id)
                ->assertVisible("h1")
                ->assertSeeIn("h1", $this->e->nombre)
                ->assertVisible("@h3-general")
                ->assertVisible("@h3-ropo")
                ->assertVisible("@separator")
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
                ->assertVisible("@txt-observaciones");

            $browser
                ->assertVisible("@label-ropo_capacitacion")
                ->assertVisible("@trigger-ropo_capacitacion")
                ->assertVisibleByName("select", "ropo.capacitacion")
                ->assertVisible("@label-ropo_nro")
                ->assertVisible("@input-ropo_nro")
                ->assertVisible("@label-ropo_caducidad")
                ->assertVisible("@trigger-ropo_caducidad");

            $browser->screenshot("empresa/show/visibilidad");
        });
    }

    public function testValorCampos(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(
                    new Form(
                        recurso: "empresas",
                        accion: "show",
                        id: $this->e->id
                    )
                )
                ->assertInputValue("h1", $this->e->nombre)
                ->assertInputValue("@input-nif", $this->e->nif)
                ->assertInputValue("@input-email", $this->e->email)
                ->assertInputValue("@input-tel", $this->e->tel)
                ->assertInputValue("@input-codigo", $this->e->codigo)
                ->assertSelectedByName("perfil", $this->e->perfil)
                ->assertInputValue("@txt-direccion", $this->e->direccion)
                ->assertInputValue(
                    "@txt-observaciones",
                    $this->e->observaciones
                );

            $browser
                ->assertSelectedByName(
                    "ropo.capacitacion",
                    $this->e->ropo["capacitacion"]
                )
                ->assertInputValue("@input-ropo_nro", $this->e->ropo["nro"])
                ->assertInputValue(
                    "@input-ropo_caducidad",
                    $this->e->ropo["caducidad"]
                );

            $browser->screenshot("empresa/show/valores");
        });
    }

    public function testCamposInhabilitados(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(
                    new Form(
                        recurso: "empresas",
                        accion: "show",
                        id: $this->e->id
                    )
                )
                ->assertDisabled("@input-nif")
                ->assertDisabled("@input-email")
                ->assertDisabled("@input-tel")
                ->assertDisabled("@input-codigo")
                ->assertDisabled("@txt-direccion")
                ->assertDisabled("@txt-observaciones")
                ->assertDisabled("@trigger-ropo_capacitacion")
                ->assertDisabled("@input-ropo_nro")
                ->assertDisabled("@trigger-ropo_caducidad");

            $browser->screenshot("empresa/show/deshabilitados");
        });
    }

    public function testBadges(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(
                    new Form(
                        recurso: "empresas",
                        accion: "show",
                        id: $this->e->id
                    )
                )
                ->assertSeeIn(
                    selector: "@badge-created-" . $this->e->id,
                    text: date("d/m/Y, H:i:s", strtotime($this->e->created_at))
                )
                ->assertSeeIn(
                    selector: "@badge-updated-" . $this->e->id,
                    text: date("d/m/Y, H:i:s", strtotime($this->e->updated_at)),
                    ignoreCase: true
                );

            $browser
                ->assertEnabled("@badge-edit-" . $this->e->id)
                ->click("@badge-edit-" . $this->e->id)
                ->pause(1750)
                ->assertPathIs(
                    "/app/recurso/empresas/" . $this->e->id . "/edit"
                );

            $browser
                ->visit(
                    new Form(
                        recurso: "empresas",
                        accion: "show",
                        id: $this->e->id
                    )
                )
                ->click("@badge-destroy-" . $this->e->id)
                ->pause(750)
                ->assertVisible("@alertdialog")
                ->assertVisible("#alert-title")
                ->assertVisible("#alert-footer")
                ->assertVisible("#alert-cancel")
                ->assertVisible("#alert-confirm")
                ->click("#alert-cancel")
                ->pause(750)
                ->assertPathIs("/app/recurso/empresas/" . $this->e->id)
                ->click("@badge-destroy-" . $this->e->id)
                ->pause(750)
                ->click("#alert-confirm")
                ->pause(750)
                ->assertPathIs("/app/recurso/empresas");
        });
    }

    public function testRegreso(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(
                    new Form(
                        recurso: "empresas",
                        accion: "show",
                        id: $this->e->id
                    )
                )
                ->click("@back-btn")
                ->pause(750)
                ->assertPathIs("/app/recurso/empresas");
        });
    }

    public function testAcciones(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(
                    new Form(
                        recurso: "empresas",
                        accion: "show",
                        id: $this->e->id
                    )
                )
                ->assertSeeIn(
                    selector: "@badge-created-" . $this->e->id,
                    text: date("d/m/Y, H:i:s", strtotime($this->e->created_at)),
                    ignoreCase: true
                )
                ->assertSeeIn(
                    selector: "@badge-updated-" . $this->e->id,
                    text: date("d/m/Y, H:i:s", strtotime($this->e->updated_at)),
                    ignoreCase: true
                );

            $browser
                ->assertEnabled("@badge-edit-" . $this->e->id)
                ->click("@badge-edit-" . $this->e->id)
                ->pause(1750)
                ->assertPathIs(
                    "/app/recurso/empresas/" . $this->e->id . "/edit"
                );

            $browser
                ->visit(
                    new Form(
                        recurso: "empresas",
                        accion: "show",
                        id: $this->e->id
                    )
                )
                ->click("@badge-destroy-" . $this->e->id)
                ->pause(750)
                ->assertVisible("@alertdialog")
                ->assertVisible("#alert-title")
                ->assertVisible("#alert-footer")
                ->assertVisible("#alert-cancel")
                ->assertVisible("#alert-confirm")
                ->click("#alert-cancel")
                ->pause(750)
                ->assertPathIs("/app/recurso/empresas/" . $this->e->id)
                ->click("@badge-destroy-" . $this->e->id)
                ->pause(750)
                ->click("#alert-confirm")
                ->pause(750)
                ->assertPathIs("/app/recurso/empresas");
        });

        $this->assertDatabaseMissing("empresas", [
            "id" => $this->e->id,
        ]);
    }
}
