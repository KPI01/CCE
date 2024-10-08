<?php

namespace Tests\Browser\Show;

use App\Models\Maquina;
use Carbon\Carbon;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Recursos\Form;
use Tests\RecursoDuskTestCase;

class ShowMaquinaTest extends RecursoDuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->hasDeleteBtn = true;
        $this->class = Maquina::class;
        $this->recurso = "maquina";
        $this->row = Maquina::factory(1)->create()->first();
        $this->PARAMS = ["maquina", "show", $this->row->id];
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
                ->assertEnabled("@badge-destroy")
                ->assertVisible("@badge-edit")
                ->assertEnabled("@badge-edit")
                ->assertVisible("@badge-createdAt")
                ->assertVisible("@badge-updatedAt");

            $browser
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
        });
    }

    public function testCamposInhabilitados(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->assertDisabled("@input-matricula")
                ->assertDisabled("@trigger-tipo")
                ->assertDisabledByName("select", "tipo")
                ->assertDisabled("@input-fabricante")
                ->assertDisabled("@input-modelo")
                ->assertDisabled("@input-marca")
                ->assertDisabled("@input-roma")
                ->assertDisabled("@input-nro_serie")
                ->assertDisabled("@trigger-cad_iteaf")
                ->assertDisabled("@txt-observaciones");
        });
    }

    public function testValidacionInformacion(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->assertSeeIn("@title", $this->row->nombre)
                ->assertInputValue("@input-matricula", $this->row->matricula)
                ->assertSeeIn("@trigger-tipo", $this->row->tipo)
                ->assertInputValue("@input-fabricante", $this->row->fabricante)
                ->assertInputValue("@input-modelo", $this->row->modelo)
                ->assertInputValue("@input-marca", $this->row->marca)
                ->assertInputValue("@input-roma", $this->row->roma)
                ->assertInputValue("@input-nro_serie", $this->row->nro_serie)
                ->assertSeeIn(
                    "@trigger-cad_iteaf",
                    Carbon::parse($this->row->cad_iteaf)->format("d/m/Y")
                )
                ->assertInputValue(
                    "@txt-observaciones",
                    $this->row->observaciones
                );
        });
    }
}
