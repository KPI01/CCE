<?php

namespace Tests\Browser\Table;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Recursos\Persona\Table;
use Tests\DuskTestCase;

class TablePersonaTest extends DuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testAcceso(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table)
                ->responsiveScreenshots('Recursos/Persona/Table/acceso');
        });
    }

    public function testAccesibilidadVisual(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table)
                ->assertPresent('@filtros-btn')
                ->assertVisible('@filtros-btn')
                ->assertPresent('@visibilidad-btn')
                ->assertVisible('@visibilidad-btn')
                ->assertPresent('@datatable')
                ->assertVisible('@datatable')
                ->assertPresent('@page-size')
                ->assertVisible('@page-size')
                ->assertPresent('@page-count')
                ->assertVisible('@page-count')
                ->assertPresent('@goTo-primera')
                ->assertVisible('@goTo-primera')
                ->assertPresent('@goTo-ultima')
                ->assertVisible('@goTo-ultima')
                ->assertPresent('@goTo-prev')
                ->assertVisible('@goTo-prev')
                ->assertPresent('@goTo-next')
                ->assertVisible('@goTo-next');

            $browser->screenshot('Recursos/Persona/Table/accesibilidad_visual');
        });
    }

    public function testMostrarFiltros(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table)
                ->assertPresent('@filtros-btn')
                ->click('@filtros-btn')
                ->pause(500)
                ->assertPresent('@filtros-content')
                ->assertVisible('@filtros-content');

            $browser->responsiveScreenshots('Recursos/Persona/Table/mostrar_filtros');
        });
    }

    public function testDropdownVisibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table)
                ->assertPresent('@visibilidad-btn')
                ->assertButtonEnabled('@visibilidad-btn');

            $browser->click('@visibilidad-btn');

            $browser->assertPresent('@visibilidad-content')
                ->assertVisible('@visibilidad-content')
                ->assertPresent('@v-toggle-email')
                ->assertPresent('@v-toggle-tel')
                ->assertPresent('@v-toggle-perfil')
                ->assertPresent('@v-toggle-ropo_tipo')
                ->assertPresent('@v-toggle-ropo_nro')
                ->assertPresent('@v-toggle-ropo_caducidad')
                ->assertPresent('@v-toggle-ropo_tipo_aplicador')
                ->assertVisible('@v-toggle-email')
                ->assertVisible('@v-toggle-tel')
                ->assertVisible('@v-toggle-perfil')
                ->assertVisible('@v-toggle-ropo_tipo')
                ->assertVisible('@v-toggle-ropo_nro')
                ->assertVisible('@v-toggle-ropo_caducidad')
                ->assertVisible('@v-toggle-ropo_tipo_aplicador');

            // $browser->storeSource('Recursos/Persona/listado-dropdown_visibilidad.html');

            $browser->clickAtPoint(100, 100);

            $browser->responsiveScreenshots('Recursos/Persona/Table/dropdown_visibilidad');
        });
    }

    public function testVisibilidadColumnas(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table)
                ->pause(500)
                ->assertPresent('@header-nombres')
                ->assertPresent('@header-apellidos')
                ->assertPresent('@header-id_nac')
                ->assertPresent('@header-email')
                ->assertPresent('@header-tel')
                ->assertPresent('@visibilidad-btn')
                ->assertEnabled('@visibilidad-btn');

            $browser->click('@visibilidad-btn');

            $browser->assertPresent('@visibilidad-content')
                ->assertVisible('@v-toggle-email')
                ->assertVisible('@v-toggle-tel')
                ->assertVisible('@v-toggle-perfil')
                ->assertVisible('@v-toggle-ropo_tipo')
                ->assertVisible('@v-toggle-ropo_nro')
                ->assertVisible('@v-toggle-ropo_caducidad')
                ->click('@v-toggle-tel')
                ->assertNotPresent('@header-tel');
        });
    }
}
