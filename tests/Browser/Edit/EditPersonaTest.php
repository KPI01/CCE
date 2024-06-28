<?php

namespace Tests\Browser\Edit;

use App\Models\Persona;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Recursos\Persona\Edit;
use Tests\DuskTestCase;

class EditPersonaTest extends DuskTestCase
{
    public Persona $p;

    public function setUp(): void
    {
        parent::setUp();

        $f = Persona::factory()->create();
        $this->p = $f->first();

        $ropoNro = '';
        do {
            if (fake()->boolean(50)) {
                $ropoNro = fake()->regexify('/^[0-9]{9}[S]{1}[SUA]{1}[\/]{1}[0-9]{1,2}$/');
            } else {
                $ropoNro = fake()->regexify('/^[0-9]{2,3}[\/][0-9]{1,2}$/');
            }
        } while (strlen($ropoNro) > 25);

        $tipo = fake()->randomElement(['Aplicador', 'Técnico']);

        DB::table('ropo')->insert([
            'persona' => $this->p->id,
            'nro' => $ropoNro,
            'caducidad' => fake()->dateTimeBetween('now', '+5 years')->format('Y-m-d'),
            'tipo' => $tipo,
            'tipo_aplicador' => $tipo ? fake()->randomElement(['Básico', 'Cualificado', 'Fumigación', 'Piloto', 'Aplicación Fitosanitarios']) : null 
        ]);
    }

    public function testAcceso(): void
    {
        //
        $this->browse(function (Browser $browser) {
            $browser->visit(new Edit($this->p));
        });
    }

    public function testAccesibilidad(): void
    {
        //
        $this->browse(function (Browser $browser) {
            $browser->visit(new Edit($this->p))
                ->assertPresent('@form')
                ->assertPresent('@separator')
                ->assertPresent('@h3-datos_personales')
                ->assertPresent('@h3-ropo')
                ->assertPresent('@label-nombres')
                ->assertPresent('@input-nombres')
                ->assertPresent('@label-apellidos')
                ->assertPresent('@input-apellidos')
                ->assertPresent('@label-id_nac')
                ->assertPresent('@trigger-tipo_id_nac')
                ->assertPresent('@input-id_nac')
                ->assertPresent('@label-email')
                ->assertPresent('@input-email')
                ->assertPresent('@label-tel')
                ->assertPresent('@input-tel')
                ->assertPresent('@label-perfil')
                ->assertPresent('@trigger-perfil')
                ->assertPresent('@label-ropo_tipo')
                ->assertPresent('@trigger-ropo_tipo')
                ->assertPresent('@label-ropo_nro')
                ->assertPresent('@input-ropo_nro')
                ->assertPresent('@label-ropo_caducidad')
                ->assertPresent('@trigger-ropo_caducidad')
                ->assertPresent('@input-ropo_caducidad')
                ->assertPresent('@label-ropo_tipo_aplicador')
                ->assertPresent('@trigger-ropo_tipo_aplicador')
                ->assertPresentByName('select', 'tipo_id_nac')
                ->assertPresentByName('select', 'perfil')
                ->assertPresentByName('select', 'ropo.tipo')
                ->assertPresentByName('select', 'ropo.tipo_aplicador');

            $browser->assertVisible('@form')
                ->assertVisible('@separator')
                ->assertVisible('@h3-datos_personales')
                ->assertVisible('@h3-ropo')
                ->assertVisible('@label-nombres')
                ->assertVisible('@input-nombres')
                ->assertVisible('@label-apellidos')
                ->assertVisible('@input-apellidos')
                ->assertVisible('@label-id_nac')
                ->assertVisible('@trigger-tipo_id_nac')
                ->assertVisible('@input-id_nac')
                ->assertVisible('@label-email')
                ->assertVisible('@input-email')
                ->assertVisible('@label-tel')
                ->assertVisible('@input-tel')
                ->assertVisible('@label-perfil')
                ->assertVisible('@trigger-perfil')
                ->assertVisible('@label-ropo_tipo')
                ->assertVisible('@trigger-ropo_tipo')
                ->assertVisible('@label-ropo_nro')
                ->assertVisible('@input-ropo_nro')
                ->assertVisible('@label-ropo_caducidad')
                ->assertVisible('@trigger-ropo_caducidad')
                ->assertVisible('@label-ropo_tipo_aplicador')
                ->assertVisible('@trigger-ropo_tipo_aplicador')
                ->assertVisibleByName('select', 'tipo_id_nac')
                ->assertVisibleByName('select', 'perfil')
                ->assertVisibleByName('select', 'ropo.tipo')
                ->assertVisibleByName('select', 'ropo.tipo_aplicador');

            $browser->assertEnabled('@input-nombres')
                ->assertEnabled('@input-apellidos')
                ->assertButtonEnabled('@trigger-tipo_id_nac')
                ->assertEnabledByName('select', 'tipo_id_nac')
                ->assertEnabled('@input-id_nac')
                ->assertEnabled('@input-email')
                ->assertEnabled('@input-tel')
                ->assertButtonEnabled('@trigger-perfil')
                ->assertEnabledByName('select', 'perfil')
                ->assertButtonEnabled('@trigger-ropo_tipo')
                ->assertEnabledByName('select', 'ropo.tipo')
                ->assertEnabled('@input-ropo_nro')
                ->assertButtonEnabled('@trigger-ropo_caducidad')
                ->assertButtonEnabled('@trigger-ropo_tipo_aplicador')
                ->assertEnabledByName('select', 'ropo.tipo_aplicador');

            $browser->responsiveScreenshots('Recurso/Persona/Edit/accesibilidad');
        });

    }

    public function testValorDeCampos(): void
    {
        //
        $this->p->save();
        $this->browse(function (Browser $browser) {
            
            $browser->visit(new Edit($this->p));

            $browser->assertValue('@input-nombres', $this->p->nombres)
                ->assertValue('@input-apellidos', $this->p->apellidos)
                ->assertSelectedByName('select', 'tipo_id_nac', $this->p->tipo_id_nac)
                ->assertValue('@input-id_nac', $this->p->id_nac)
                ->assertValue('@input-email', $this->p->email)
                ->assertValue('@input-tel', $this->p->tel)
                ->assertSelectedByName('select', 'perfil', $this->p->perfil);
            
            if ($this->p->ropo) {
                // dd($this->p->ropo);
                $i = $this->p->ropo;
                $browser->assertValue('@input-ropo_nro', $i['nro'])
                    ->assertValue('@input-ropo_caducidad', $i['caducidad'])
                    ->assertSelectedByName('select', 'ropo.tipo', $i['tipo'])
                    ->assertSelectedByName('select', 'ropo.tipo_aplicador', $i['tipo_aplicador']);
            }
        });
    }

    public function testEnvioVacio(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Edit($this->p));
             
            $browser->value('@input-nombres', '')
                ->value('@input-apellidos', '')
                ->value('@input-id_nac', '')
                ->value('@input-email', '')
                ->value('@input-tel', '')
                ->value('@input-ropo_nro', '')
                ->value('@input-ropo_caducidad', '')
                ->select('@trigger-tipo_id_nac', '')
                ->select('@trigger-perfil', '')
                ->select('@trigger-ropo_tipo', '')
                ->select('@trigger-ropo_caducidad', '')
                ->select('@trigger-ropo-aplicador', '')
                ->press('@submit');
        });
    }
}
