<?php

namespace Tests\Browser\Table;

use App\Models\Persona;
use Illuminate\Support\Facades\Schema;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\Recursos\Table;
use Tests\DuskTestCase;

class TablePersonaTest extends DuskTestCase
{
    public function testAcceso(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("personas"));
        });
    }

    public function testAccesibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("personas"))->assertSee("Personas");

            $browser->within(new Navbar(), function ($browser) {
                $browser
                    ->assertPresent("@navbar")
                    ->assertPresent("@acc-home")
                    ->assertPresent("@acc-recursos")
                    ->assertPresent("@acc-config");
            });

            $browser
                ->assertPresent("@container")
                ->assertPresent("@dt")
                ->assertPresent("@thead")
                ->assertPresent("@tbody")
                ->assertPresent("@v-btn")
                ->assertEnabled("@v-btn")
                ->click("@v-btn")
                ->pause(500)
                ->assertPresent("@v-content")
                ->visit(new Table("personas"))
                ->assertNotPresent("@v-content")
                ->assertPresent("@f-btn")
                ->assertEnabled("@f-btn")
                ->click("@f-btn")
                ->pause(500)
                ->assertPresent("@f-content")
                ->visit(new Table("personas"))
                ->assertNotPresent("@f-content")
                ->assertPresent("@p-container")
                ->assertPresent("@p-size-btn")
                ->assertEnabled("@p-size-btn")
                ->click("@p-size-btn")
                ->pause(500)
                ->assertPresent("@radix-popper")
                ->assertPresent("@p-indexing")
                ->assertSeeIn("@p-indexing", "Página")
                ->assertPresent("@pag-primera")
                ->assertPresent("@pag-anterior")
                ->assertPresent("@pag-siguiente")
                ->assertPresent("@pag-ultima");
        });
    }

    public function testVisibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Table("personas"))
                ->within(new Navbar(), function (Browser $browser) {
                    $browser
                        ->assertVisible("@navbar")
                        ->assertVisible("@acc-home")
                        ->assertVisible("@acc-recursos")
                        ->assertVisible("@acc-config");
                });

            $browser
                ->assertVisible("@container")
                ->assertVisible("@dt")
                ->assertVisible("@thead")
                ->assertVisible("@tbody")
                ->assertVisible("@v-btn")
                ->assertEnabled("@v-btn")
                ->click("@v-btn")
                ->pause(750)
                ->assertVisible("@v-content")
                ->visit(new Table("personas"))
                ->assertVisible("@f-btn")
                ->assertEnabled("@f-btn")
                ->click("@f-btn")
                ->pause(750)
                ->assertVisible("@f-content")
                ->visit(new Table("personas"))
                ->assertVisible("@p-container")
                ->assertVisible("@p-size-btn")
                ->assertEnabled("@p-size-btn")
                ->click("@p-size-btn")
                ->pause(500)
                ->assertVisible("@radix-popper")
                ->assertVisible("@p-indexing")
                ->assertSeeIn("@p-indexing", "Página")
                ->assertVisible("@pag-primera")
                ->assertVisible("@pag-anterior")
                ->assertVisible("@pag-siguiente")
                ->assertVisible("@pag-ultima");
        });
    }

    public function testContenidoFilas(): void
    {
        Schema::disableForeignKeyConstraints();
        Persona::truncate();

        $this->assertDatabaseEmpty("personas");

        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("personas"));

            $browser
                ->assertPresent("@dt")
                ->assertVisible("@dt")
                ->assertSeeIn("@tbody", "Sin registros.");
        });

        Persona::factory(10)->create();

        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("personas"));

            $browser
                ->assertPresent("@dt")
                ->assertVisible("@dt")
                ->assertDontSeeIn("@tbody", "Sin registros.");
        });
    }

    public function testFiltros(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("personas"));

            $browser
                ->assertPresent("@f-btn")
                ->assertEnabled("@f-btn")
                ->click("@f-btn")
                ->pause(750)
                ->assertPresent("@f-content")
                ->assertVisible("@f-content");
        });
    }

    public function testVisibilidadColumnas(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("personas"));

            $browser
                ->assertPresent("@v-btn")
                ->assertEnabled("@v-btn")
                ->click("@v-btn")
                ->pause(750)
                ->assertPresent("@v-content")
                ->assertVisible("@v-content");
        });
    }

    public function testPaginacion(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("personas"));

            $browser
                ->assertPresent("@p-container")
                ->assertPresent("@p-size-btn")
                ->assertEnabled("@p-size-btn")
                ->click("@p-size-btn")
                ->pause(750)
                ->assertPresent("@radix-popper")
                ->assertVisible("@radix-popper")
                ->assertPresent("@radix-item:nth-child(n)");
        });
    }

    public function testMenuFilas(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("personas"));

            $browser
                ->assertPresent("@r-menu")
                ->assertEnabled("@r-menu")
                ->click("@r-menu")
                ->pause(750)
                ->assertPresent("@radix-popper")
                ->assertVisible("@radix-popper")
                ->assertPresent("@acc-show")
                ->assertPresent("@acc-edit")
                ->assertPresent("@acc-delete")
                ->assertVisible("@acc-show")
                ->assertVisible("@acc-edit")
                ->assertVisible("@acc-delete");
        });
    }

    public function testGoToCreate(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Table("personas"))
                ->click("@acc-create")
                ->pause(750)
                ->assertUrlIs(route("personas.create"));
        });
    }
}
