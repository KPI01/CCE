<?php

namespace Tests\Browser;

use App\Models\Empresa;
use Database\Seeders\EmpresaSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\Recursos\Table;
use Tests\DuskTestCase;

class TableEmpresaTest extends DuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->table = (new Empresa())->getTable();
    }
    public function testAcceso(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("empresa"));
        });
    }

    public function testAccesibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Table("empresa"))
                ->within(new Navbar(), function (Browser $browser) {
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
            $browser->visit(new Table("empresa"));

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
            $browser->visit(new Table("empresa"));

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
            $browser->visit(new Table("empresa"));

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
            $browser->visit(new Table("empresa"));

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
        Schema::disableForeignKeyConstraints();
        Empresa::truncate();
        DB::table(Empresa::ROPO_TABLE)->truncate();

        $this->seed(EmpresaSeeder::class);

        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("empresa"));

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
        Empresa::truncate();

        $this->assertDatabaseEmpty($this->table);

        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("empresa"));

            $browser
                ->assertPresent("@dt")
                ->assertVisible("@dt")
                ->assertSeeIn("@tbody", "Sin registros.");
        });

        $this->seed(EmpresaSeeder::class);

        $this->browse(function (Browser $browser) {
            $browser->visit(new Table("empresa"));

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
                ->visit(new Table("empresa"))
                ->click("@acc-create")
                ->pause(750)
                ->assertUrlIs(route("empresa.create"));
        });
    }
}
