<?php

namespace Tests\Browser\Show;

use App\Models\Campana;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Recursos\Form;
use Tests\RecursoDuskTestCase;

class ShowCampanaTest extends RecursoDuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->hasDeleteBtn = true;
        $this->class = Campana::class;
        $this->recurso = "campana";
        $inicio = fake()->date();
        $fin = fake()->dateTimeBetween(
            startDate: "+10 months",
            endDate: "+18 months"
        );
        $this->row = Campana::factory(
            count: 1,
            state: ["inicio" => $inicio, "fin" => $fin]
        )
            ->create()
            ->first();
        $this->PARAMS = ["campana", "show", $this->row->id];
    }

    public function testAccesibilidad(): void
    {
        parent::testAccesibilidad();
        $this->browse(
            callback: function (Browser $browser): void {
                $browser->visit(url: new Form(...$this->PARAMS));

                $browser
                    ->assertPresent(selector: "@breadcrumb")
                    ->assertPresent(selector: "@title")
                    ->assertPresent(selector: "@form-show-{$this->PARAMS[2]}")
                    ->assertPresent(selector: "@badge-destroy")
                    ->assertPresent(selector: "@badge-edit")
                    ->assertPresent(selector: "@badge-createdAt")
                    ->assertPresent(selector: "@badge-updatedAt");

                $browser
                    ->assertPresent(selector: "@label-is_activa")
                    ->assertPresent(selector: "@label-inicio")
                    ->assertPresent(selector: "@label-fin")
                    ->assertPresent(selector: "@label-descripcion");

                $browser
                    ->assertPresent(selector: "@switch-is_activa")
                    ->assertPresent(selector: "@trigger-inicio")
                    ->assertPresent(selector: "@input-inicio")
                    ->assertPresent(selector: "@trigger-fin")
                    ->assertPresent(selector: "@input-fin")
                    ->assertPresent(selector: "@txt-descripcion");
            }
        );
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
                ->assertVisible("@label-is_activa")
                ->assertVisible("@label-inicio")
                ->assertVisible("@label-fin")
                ->assertVisible("@label-descripcion");

            $browser
                ->assertVisible("@switch-is_activa")
                ->assertVisible("@trigger-inicio")
                ->assertVisible("@trigger-fin")
                ->assertVisible("@txt-descripcion");
        });
    }

    public function testCamposInhabilitados(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->assertDisabled("@switch-is_activa")
                ->assertDisabled("@trigger-inicio")
                ->assertDisabled("@trigger-fin")
                ->assertDisabled("@txt-descripcion");
        });
    }

    public function testValidacionInformacion(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->assertSeeIn("@title", $this->row->nombre)
                ->assertAriaAttribute(
                    "@switch-is_activa",
                    "checked",
                    $this->row->is_activa ? "true" : "false"
                )
                ->assertSeeIn("@trigger-inicio", $this->row->inicio)
                ->assertSeeIn("@trigger-fin", $this->row->fin)
                ->assertSeeIn("@txt-descripcion", $this->row->descripcion);
        });
    }
}
