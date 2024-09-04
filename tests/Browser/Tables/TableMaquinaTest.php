<?php

namespace Tests\Browser\Table;

use App\Models\Maquina;
use Database\Seeders\MaquinaSeeder;
use Illuminate\Support\Facades\Schema;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\Recursos\Table;
use Tests\DuskTestCase;

class TableMaquinaTest extends DuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->table = (new Maquina())->getTable();
    }
    public function testAcceso(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("maquina"));
        });
    }

    public function testAccesibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("maquina"));

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
            $browser->visit(new Table("maquina"));

            $browser->within(new Navbar(), function (Browser $browser) {
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
                ->assertVisible("@p-indexing")
                ->assertSeeIn("@p-indexing", "Página")
                ->assertVisible("@pag-primera")
                ->assertVisible("@pag-anterior")
                ->assertVisible("@pag-siguiente")
                ->assertVisible("@pag-ultima");
        });
    }

    public function testMenuVisibilidadColumnas(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("maquina"));

            $browser
                ->assertPresent("@v-btn")
                ->assertVisible("@v-btn")
                ->assertEnabled("@v-btn")
                ->click("@v-btn")
                ->pause(1000)
                ->assertPresent("@radix-popper")
                ->assertVisible("@radix-popper")
                ->assertPresent("@radix-menu-item-checkbox");
        });
    }

    public function testMenuFiltros(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("maquina"));

            $browser
                ->assertPresent("@f-btn")
                ->assertVisible("@f-btn")
                ->assertEnabled("@f-btn")
                ->click("@f-btn")
                ->pause(1000)
                ->assertPresent("@f-content")
                ->assertVisible("@f-content")
                ->assertPresent("@f-title")
                ->assertVisible("@f-title")
                ->assertPresent("@f-descrip")
                ->assertVisible("@f-descrip")
                ->assertPresent("@f-close")
                ->assertVisible("@f-close")
                ->assertPresent("@f-reset")
                ->assertVisible("@f-reset");
        });
    }

    public function testMenuPaginacion(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("maquina"));

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
        Maquina::truncate();
        $this->seed(MaquinaSeeder::class);

        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("maquina"));

            $browser
                ->assertPresent("@r-menu")
                ->assertEnabled("@r-menu")
                ->click("@r-menu")
                ->pause(750)
                ->assertPresent("@radix-popper")
                ->assertVisible("@radix-popper")
                ->assertPresent("@acc-show")
                ->assertPresent("@acc-edit")
                ->assertPresent("@acc-destroy")
                ->assertVisible("@acc-show")
                ->assertVisible("@acc-edit")
                ->assertVisible("@acc-destroy");
        });
    }

    public function testContenidoFilas(): void
    {
        Schema::disableForeignKeyConstraints();
        Maquina::truncate();

        $this->assertDatabaseEmpty($this->table);

        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("maquina"));

            $browser
                ->assertPresent("@dt")
                ->assertVisible("@dt")
                ->assertSeeIn("@tbody", "Sin registros.");
        });

        $this->seed(MaquinaSeeder::class);

        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("maquina"));

            $browser
                ->assertPresent("@dt")
                ->assertVisible("@dt")
                ->assertDontSeeIn("@tbody", "Sin registros.");
        });
    }

    public function testGoToCreate(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Table("maquina"))
                ->click("@acc-create")
                ->pause(750)
                ->assertUrlIs(route("maquina.create"));
        });
    }
}
