<?php

namespace Tests\Browser\Forms;

use App\Models\Empresa;
use Carbon\Carbon;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Recursos\Form;
use Tests\RecursoDuskTestCase;

class ShowEmpresaTest extends RecursoDuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->hasDeleteBtn = true;
        $this->class = Empresa::class;
        $this->recurso = "empresa";
        $this->row = Empresa::factory(1)->withRopo()->create()->first();
        $this->PARAMS = ["empresa", "show", $this->row->id];
    }

    public function testAccesibilidad(): void
    {
        parent::testAccesibilidad();
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->assertPresent("@breadcrumb")
                ->assertPresent("@title")
                ->assertPresent("@form-show-{$this->PARAMS[2]}")
                ->assertPresent("@badge-destroy")
                ->assertPresent("@badge-edit")
                ->assertPresent("@badge-createdAt")
                ->assertPresent("@badge-updatedAt");

            $browser
                ->assertPresent("@label-nif")
                ->assertPresent("@label-email")
                ->assertPresent("@label-tel")
                ->assertPresent("@label-codigo")
                ->assertPresent("@label-perfil")
                ->assertPresent("@label-direccion")
                ->assertPresent("@label-observaciones");

            $browser
                ->assertPresent("@input-nif")
                ->assertPresent("@input-email")
                ->assertPresent("@input-tel")
                ->assertPresent("@input-codigo")
                ->assertPresent("@trigger-perfil")
                ->assertPresentByName("select", "perfil")
                ->assertPresent("@txt-direccion")
                ->assertPresent("@txt-observaciones");

            $browser
                ->assertPresent("@label-ropo_capacitacion")
                ->assertPresent("@label-ropo_nro")
                ->assertPresent("@label-ropo_caducidad");

            $browser
                ->assertPresent("@trigger-ropo_capacitacion")
                ->assertPresentByName("select", '"ropo.capacitacion"')
                ->assertPresent("@input-ropo_nro")
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
                ->assertVisible("@form-show-{$this->PARAMS[2]}")
                ->assertVisible("@badge-destroy")
                ->assertVisible("@badge-edit")
                ->assertVisible("@badge-createdAt")
                ->assertVisible("@badge-updatedAt");

            $browser
                ->assertVisible("@label-nif")
                ->assertVisible("@label-email")
                ->assertVisible("@label-tel")
                ->assertVisible("@label-codigo")
                ->assertVisible("@label-perfil")
                ->assertVisible("@label-direccion")
                ->assertVisible("@label-observaciones");

            $browser
                ->assertVisible("@input-nif")
                ->assertVisible("@input-email")
                ->assertVisible("@input-tel")
                ->assertVisible("@input-codigo")
                ->assertVisible("@trigger-perfil")
                ->assertVisibleByName("select", "perfil")
                ->assertVisible("@txt-direccion")
                ->assertVisible("@txt-observaciones");

            $browser
                ->assertVisible("@label-ropo_capacitacion")
                ->assertVisible("@label-ropo_nro")
                ->assertVisible("@label-ropo_caducidad");

            $browser
                ->assertVisible("@trigger-ropo_capacitacion")
                ->assertVisibleByName("select", '"ropo.capacitacion"')
                ->assertVisible("@input-ropo_nro")
                ->assertVisible("@trigger-ropo_caducidad");
        });
    }

    public function testCamposInhabilitados(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->assertDisabled("@input-nif")
                ->assertDisabled("@input-email")
                ->assertDisabled("@input-tel")
                ->assertDisabled("@input-codigo")
                ->assertDisabled("@trigger-perfil")
                ->assertDisabledByName("select", "perfil")
                ->assertDisabled("@txt-direccion")
                ->assertDisabled("@txt-observaciones");

            $browser
                ->assertDisabled("@trigger-ropo_capacitacion")
                ->assertDisabledByName("select", '"ropo.capacitacion"')
                ->assertDisabled("@input-ropo_nro")
                ->assertDisabled("@trigger-ropo_caducidad");
        });
    }

    public function testValidacionInformacion(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->assertSeeIn("@title", $this->row->nombre)
                ->assertInputValue("@input-nif", $this->row->nif)
                ->assertInputValue("@input-email", $this->row->email)
                ->assertInputValue("@input-tel", $this->row->tel)
                ->assertInputValue("@input-codigo", $this->row->codigo)
                ->assertSeeIn("@trigger-perfil", $this->row->perfil)
                ->assertInputValue("@txt-direccion", $this->row->direccion)
                ->assertInputValue(
                    "@txt-observaciones",
                    $this->row->observaciones
                );

            $browser
                ->assertSeeIn(
                    "@trigger-ropo_capacitacion",
                    $this->row->ropo["capacitacion"]
                )
                ->assertInputValue("@input-ropo_nro", $this->row->ropo["nro"])
                ->assertSeeIn(
                    "@trigger-ropo_caducidad",
                    Carbon::parse($this->row->ropo["caducidad"])->format(
                        "d/m/Y"
                    )
                );
        });
    }

    public function testGoToEdit(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser->click("@badge-edit")->pause(1000);

            $browser->assertRouteIs("empresa.edit", [
                "empresa" => $this->row->id,
            ]);
        });
    }
}
