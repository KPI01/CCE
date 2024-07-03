<?php

namespace Tests\Browser\Show;

use App\Models\Persona;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\Recursos\Persona\Show;
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
            $browser->visit(new Show($this->p));
        });
    }

    public function testAccesibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Show($this->p));

            $browser->within(new Navbar, function ($browser) {
                $browser->assertPresent('@titulo')
                    ->assertPresent('@home-btn')
                    ->assertPresent('@conf-btn')
                    ->assertPresent('@nav')
                    ->assertPresent('@list')
                    ->assertPresent('@rsrc-btn');
            });

            $browser->assertPresent('@form')
                ->assertPresent('h1')
                ->assertPresent('@h3-basicos')
                ->assertPresent('@h3-ropo')
                ->assertPresent('@label-id_nac')
                ->assertPresent('@trigger-tipo_id_nac')
                ->assertPresentByName('select', 'tipo_id_nac')
                ->assertPresent('@input-id_nac')
                ->assertPresent('@label-email')
                ->assertPresent('@input-email')
                ->assertPresent('@label-tel')
                ->assertPresent('@input-tel')
                ->assertPresent('@label-perfil')
                ->assertPresent('@trigger-perfil')
                ->assertPresent('@label-observaciones')
                ->assertPresent('@txt-observaciones')
                ->assertPresent('@label-ropo_tipo')
                ->assertPresent('@trigger-ropo_tipo')
                ->assertPresentByName('select', 'ropo.tipo')
                ->assertPresent('@label-ropo_nro')
                ->assertPresent('@input-ropo_nro')
                ->assertPresent('@input-ropo_caducidad')
                ->assertPresent('@label-ropo_tipo_aplicador')
                ->assertPresent('@trigger-ropo_tipo_aplicador')
                ->assertPresentByName('select', 'ropo.tipo_aplicador');

            $browser->responsiveScreenshots('persona/show/accesibilidad');
        });
    }

    public function testVisibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Show($this->p));

            $browser->within(new Navbar, function ($browser) {
                $browser->assertVisible('@home-btn')
                    ->assertVisible('@conf-btn')
                    ->assertVisible('@nav')
                    ->assertVisible('@list')
                    ->assertVisible('@rsrc-btn');
            });

            $browser->assertVisible('@form')
                ->assertVisible('@separator')
                ->assertVisible('@h3-basicos')
                ->assertVisible('@h3-ropo')
                ->assertVisible('@label-id_nac')
                ->assertVisible('@trigger-tipo_id_nac')
                ->assertVisible('@input-id_nac')
                ->assertVisible('@label-email')
                ->assertVisible('@input-email')
                ->assertVisible('@label-tel')
                ->assertVisible('@input-tel')
                ->assertVisible('@label-perfil')
                ->assertVisible('@trigger-perfil')
                ->assertVisible('@label-observaciones')
                ->assertVisible('@txt-observaciones')
                ->assertVisible('@label-ropo_tipo')
                ->assertVisible('@trigger-ropo_tipo')
                ->assertVisible('@label-ropo_nro')
                ->assertVisible('@input-ropo_nro')
                ->assertVisible('@input-ropo_caducidad')
                ->assertVisible('@label-ropo_tipo_aplicador')
                ->assertVisible('@trigger-ropo_tipo_aplicador');
        });
    }

    public function testCamposInhabilitados(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Show($this->p))
                ->assertDisabled('@input-id_nac')
                ->assertDisabled('@input-email')
                ->assertDisabled('@input-tel')
                ->assertDisabled('@trigger-perfil')
                ->assertDisabled('@txt-observaciones')
                ->assertDisabled('@trigger-ropo_tipo')
                ->assertDisabled('@input-ropo_nro')
                ->assertDisabled('@input-ropo_caducidad')
                ->assertDisabled('@trigger-ropo_tipo_aplicador');
        });
    }

    public function testValorDeCampos(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Show($this->p))
                ->assertSeeIn('h1', $this->p->nombres . " " . $this->p->apellidos)
                ->assertSelectedByName('tipo_id_nac', $this->p->tipo_id_nac)
                ->assertInputValue('@input-id_nac', $this->p->id_nac)
                ->assertInputValue('@input-email', $this->p->email)
                ->assertInputValue('@input-tel', $this->p->tel)
                ->assertSelectedByName('perfil', $this->p->perfil)
                ->assertInputValue('@txt-observaciones', $this->p->observaciones)
                ->assertSelectedByName('ropo.tipo', $this->p->ropo['tipo'])
                ->assertInputValue('@input-ropo_nro', $this->p->ropo['nro'])
                ->assertInputValue('@input-ropo_caducidad', date('d/m/Y', strtotime($this->p->ropo['caducidad'])))
                ->assertSelectedByName('ropo.tipo_aplicador', $this->p->ropo['tipo_aplicador']);
        });
    }

    public function testAcciones(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Show($this->p));

            $browser->assertPresent('#edit-' . $this->p->id)
                ->assertPresent('#delete-' . $this->p->id);

            $browser->assertVisible('#edit-' . $this->p->id)
                ->assertVisible('#delete-' . $this->p->id);

            $browser->click('#edit-' . $this->p->id)->pause(2000)
                ->assertPathIs('/cce/app/recurso/personas/' . $this->p->id . '/edit');

            $browser->visit(new Show($this->p))
                ->click('button#delete-' . $this->p->id)->pause(250)
                ->assertVisible('div[role="alertdialog"]');
        });
    }
}
