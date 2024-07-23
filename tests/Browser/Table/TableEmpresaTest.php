<?php

namespace Tests\Browser;

use App\Models\Empresa;
use Illuminate\Support\Facades\Schema;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\Recursos\Table;
use Tests\DuskTestCase;

class TableEmpresaTest extends DuskTestCase
{
    public function testAcceso(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("empresas"));
        });
    }

    public function testAccesibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Table("empresas"))
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
                ->assertPresent("@container")
                ->assertPresent("@dt")
                ->assertPresent("@thead")
                ->assertPresent("@tbody")
                ->assertPresent("@v-btn")
                ->assertEnabled("@v-btn")
                ->click("@v-btn")
                ->pause(500)
                ->assertPresent("@v-content")
                ->visit(new Table("empresas"))
                ->assertNotPresent("@v-content")
                ->assertPresent("@f-btn")
                ->assertEnabled("@f-btn")
                ->click("@f-btn")
                ->pause(500)
                ->assertPresent("@f-content")
                ->visit(new Table("empresas"))
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
                ->visit(new Table("empresas"))
                ->within(new Navbar(), function (Browser $browser) {
                    $browser
                        ->assertVisible("@titulo")
                        ->assertVisible("@nav")
                        ->assertVisible("@list")
                        ->assertVisible("@list")
                        ->assertVisible("@rcs-btn")
                        ->assertVisible("@conf-btn")
                        ->assertVisible("@home-btn");
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
                ->visit(new Table("empresas"))
                ->assertVisible("@f-btn")
                ->assertEnabled("@f-btn")
                ->click("@f-btn")
                ->pause(750)
                ->assertVisible("@f-content")
                ->visit(new Table("empresas"))
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
        Empresa::truncate();

        $this->assertDatabaseEmpty("empresas");

        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("empresas"));

            $browser
                ->assertPresent("@dt")
                ->assertVisible("@dt")
                ->assertSeeIn("@tbody", "Sin registros.");
        });

        Empresa::factory(10)->create();

        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("empresas"));

            $browser
                ->assertPresent("@dt")
                ->assertVisible("@dt")
                ->assertDontSeeIn("@tbody", "Sin registros.");
        });
    }

    public function testFiltros(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("empresas"));

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
            $browser->visit(new Table("empresas"));

            $browser
                ->assertPresent("@v-btn")
                ->assertEnabled("@v-btn")
                ->click("@v-btn")
                ->pause(750)
                ->assertPresent("@v-content")
                ->assertVisible("@v-content");
        });
    }

    public function testPaginación(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("empresas"));

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
}
