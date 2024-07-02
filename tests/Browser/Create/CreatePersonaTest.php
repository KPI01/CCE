<?php

namespace Tests\Browser;

use App\Models\Persona;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\Recursos\Persona\Create;
use Tests\DuskTestCase;

class CreatePersonaTest extends DuskTestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Comprobación que se puede acceder.
     */
    public function testAcceso(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Create);

            $browser->screenshot('persona/create/acceso');
        });
    }

    /**
     * Comprobación de visualización de elementos
     */
    public function testAccesibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Create);

            $browser->assertPresent('@form')
                ->assertPresent('@back')
                ->assertPresent('@label-nombres')
                ->assertPresent('@input-nombres')
                ->assertPresent('@label-apellidos')
                ->assertPresent('@input-apellidos')
                ->assertPresent('@trigger-tipo_id_nac')
                ->assertPresent('@input-id_nac')
                ->assertPresent('@label-email')
                ->assertPresent('@input-email')
                ->assertPresent('@label-tel')
                ->assertPresent('@input-tel')
                ->assertPresent('@label-perfil')
                ->assertPresent('@trigger-perfil')
                ->assertPresent('@label-observaciones')
                ->assertPresent('#input-observaciones')
                ->assertPresent('@reset')
                ->assertPresent('@submit')
                ->within(new Navbar, function (Browser $browser) {
                    $browser->assertPresent('@titulo')
                        ->assertPresent('@home-btn')
                        ->assertPresent('@conf-btn')
                        ->assertPresent('@nav')
                        ->assertPresent('@list')
                        ->assertPresent('@rsrc-btn');
                });

            $browser->assertVisible('@form')
                ->assertVisible('@back')
                ->assertVisible('@label-nombres')
                ->assertVisible('@input-nombres')
                ->assertVisible('@label-apellidos')
                ->assertVisible('@input-apellidos')
                ->assertVisible('@trigger-tipo_id_nac')
                ->assertVisible('@input-id_nac')
                ->assertVisible('@label-email')
                ->assertVisible('@input-email')
                ->assertVisible('@label-tel')
                ->assertVisible('@input-tel')
                ->assertVisible('@label-perfil')
                ->assertVisible('@trigger-perfil')
                ->assertVisible('@label-observaciones')
                ->assertVisible('#input-observaciones')
                ->assertVisible('@reset')
                ->assertVisible('@submit')
                ->within(new Navbar, function (Browser $browser) {
                    $userNombre = $this->user->nombres;
                    $browser->assertSeeIn('@titulo', "Bienvenido, $userNombre")
                        ->assertVisible('@home-btn')
                        ->assertVisible('@conf-btn')
                        ->assertVisible('@nav')
                        ->assertVisible('@list')
                        ->assertVisible('@rsrc-btn');
                });

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

            $browser->screenshot('persona/create/accesibilidad_visual');
        });
    }

    /**
     * Test de llenado de campos básicos
     */
    public function testLlenadoCampos(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Create)
                ->type('@input-nombres', 'Prueba')
                ->assertInputValue('@input-nombres', 'Prueba')
                ->type('@input-apellidos', 'Prueba')
                ->assertInputValue('@input-apellidos', 'Prueba')
                ->selectByName('tipo_id_nac', 'DNI')
                ->assertSelectedByName('tipo_id_nac', 'DNI')
                ->type('@input-id_nac', 'A12345678')
                ->assertInputValue('@input-id_nac', 'A12345678')
                ->type('@input-email', 'prueba@prueba')
                ->assertInputValue('@input-email', 'prueba@prueba')
                ->type('@input-tel', '123-456-78-90')
                ->selectByName('perfil', 'Productor')
                ->assertSelectedByName('perfil', 'Productor')
                ->assertInputValue('@input-tel', '123-456-78-90')
                ->type('@txtarea-observaciones', 'Prueba')
                ->assertInputValue('@txtarea-observaciones', 'Prueba')
                ->screenshot('persona/create/llenado_campos_basicos');
        });
    }

    /**
     * Test para mostrar el formulario completo
     */
    public function testMostrarRopo(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Create)
                ->assertPresent('@show-ropo')
                ->assertVisible('@show-ropo')
                ->assertEnabled('@show-ropo')
                ->click('@show-ropo')
                ->assertChecked('input[type="checkbox"][name="ropo"]')
                ->assertVisible('#ropo-form')
                ->screenshot('persona/create/mostrar_ropo');
        });
    }

    /**
     * Test de llenado de formulario completo
     */
    public function testLlenadoCompleto(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Create)
                ->type('@input-nombres', 'Prueba')
                ->assertInputValue('@input-nombres', 'Prueba')
                ->type('@input-apellidos', 'Prueba')
                ->assertInputValue('@input-apellidos', 'Prueba')
                ->selectByName('tipo_id_nac', 'DNI')
                ->assertSelectedByName('tipo_id_nac', 'DNI')
                ->type('@input-id_nac', 'A12345678')
                ->assertInputValue('@input-id_nac', 'A12345678')
                ->type('@input-email', 'prueba@prueba')
                ->assertInputValue('@input-email', 'prueba@prueba')
                ->type('@input-tel', '123-456-78-90')
                ->assertInputValue('@input-tel', '123-456-78-90')
                ->selectByName('perfil', 'Supervisor')
                ->assertSelectedByName('perfil', 'Supervisor')
                ->type('@txtarea-observaciones', 'Prueba')
                ->assertInputValue('@txtarea-observaciones', 'Prueba');

            $browser->click('@show-ropo')
                ->assertChecked('input[type="checkbox"][name="ropo"]');


            $browser->selectByName('ropo.tipo', 'Aplicador')
                ->assertSelectedByName('ropo.tipo', 'Aplicador')
                ->type('@input-ropo_nro', '123456789')
                ->assertInputValue('@input-ropo_nro', '123456789')
                ->selectByName('ropo.tipo_aplicador', 'Piloto')
                ->assertSelectedByName('ropo.tipo_aplicador', 'Piloto')
                ->screenshot('persona/create/llenado_completo');
        });
    }

    /**
     * Test del calendario de vencimiento de ROPO
     */
    public function testCalendarioRopo(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Create)
                ->click('@show-ropo')
                ->assertVisible('#ropo-form');

            $browser->assertPresent('@trigger-ropo_caducidad')
                ->assertVisible('@trigger-ropo_caducidad')
                ->assertEnabled('@trigger-ropo_caducidad')
                ->click('@trigger-ropo_caducidad')
                ->assertPresent('@calendar')
                ->assertVisible('@calendar')
                ->pause(1000);

            $browser->click('@calendar table tr:nth-child(3) td:nth-child(3)')
                ->pause(1000)
                ->assertInputValue('@input-ropo_caducidad', '2024-07-17')
                ->screenshot('persona/create/calendario_ropo');

            $browser->screenshot('persona/create/calendario_ropo');
        });
    }

    /**
     * Test de envío de campos requeridos vacíos
     */
    public function testEnvioRequeridosVacio(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Create)
                ->click('@submit')
                ->assertSeeIn('@msg-nombres', 'Este campo es requerido.')
                ->assertSeeIn('@msg-apellidos', 'Este campo es requerido.')
                ->assertSeeIn('@msg-id_nac', 'Este campo es requerido.')
                ->assertSeeIn('@msg-email', 'Este campo es requerido.')
                ->screenshot('persona/create/envio_vacio');
        });
    }

    /**
     * Test de envío de campos requeridos inválidos
     */
    public function testEnvioRequeridosInvalidos(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Create)
                ->type('@input-nombres', 'At')
                ->type('@input-apellidos', 'Ut')
                ->type('@input-id_nac', '2Q864422J0AK3')
                ->type('@input-email', 'Eirmod.com')
                ->press('@submit')
                ->assertSeeIn('@msg-nombres', 'El nombre debe tener al menos 3 caracteres.')
                ->assertSeeIn('@msg-apellidos', 'Los apellidos deben tener al menos 3 caracteres.')
                ->assertSeeIn('@msg-id_nac', 'El DNI/NIE debe ser de 12 caracteres.')
                ->assertSeeIn('@msg-email', 'El correo debe ser válido.')
                ->screenshot('persona/create/requeridos_invalidos_1');

            $browser->visit(new Create)
                ->type('@input-nombres', 'Accumsan tempor clita voluptua diam diam et invidunt ut dolor amet commodo')
                ->type('@input-apellidos', 'Tempor gubergren eos eirmod diam vel gubergren sadipscing euismod nonummy nonumy tincidunt')
                ->type('@input-id_nac', '7D1BJ11O3VRH76YH')
                ->type('@input-email', 'Sadipscing.com')
                ->press('@submit')
                ->assertSeeIn('@msg-nombres', 'El nombre debe tener menos de 50 caracteres.')
                ->assertSeeIn('@msg-apellidos', 'Los apellidos deben tener menos de 50 caracteres.')
                ->assertSeeIn('@msg-id_nac', 'El DNI/NIE debe ser de 12 caracteres.')
                ->assertSeeIn('@msg-email', 'El correo debe ser válido.')
                ->screenshot('persona/create/requeridos_invalidos_2');
        });
    }

    /**
     * Test de envio de campos requeridos validos pero restante invalido sin ropo
     */
    public function testEnvioRequeridosValidosBasicoInvalido(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Create)
                ->type('@input-nombres', 'Veniam')
                ->type('@input-apellidos', 'Tempor')
                ->type('@input-id_nac', '04315370H')
                ->type('@input-email', 'Accusam@correo.com')
                ->type('@input-tel', '123456789')
                ->press('@submit')
                ->assertDontSee('@msg-nombres')
                ->assertDontSee('@msg-apellidos')
                ->assertDontSee('@msg-id_nac')
                ->assertDontSee('@msg-email')
                ->assertSeeIn('@msg-tel', 'El número debe estar en el formato indicado.');

            $browser->screenshot('persona/create/envio_requeridos_validos_basico_invalido');
        });
    }

    /**
     * Test envio de campos basicos validos pero con ropo invalido
     */
    public function testEnvioBasicoValidoRopoInvalido(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Create)
                ->type('@input-nombres', 'Ipsum')
                ->type('@input-apellidos', 'Nulla')
                ->type('@input-id_nac', '90401911C')
                ->type('@input-email', 'Hendrerit@correo.com')
                ->type('@input-tel', '123-45-67-89')
                ->click('@show-ropo')
                ->assertVisible('#ropo-form')
                ->assertSelectMissingOptionByName('ropo.tipo', 'Volutpat')
                ->selectByName('ropo.tipo', 'Volutpat')
                ->type('@input-ropo_nro', '167654fdg')
                ->click('@trigger-ropo_caducidad')
                ->pause(1000)
                ->assertSelectMissingOptionByName('ropo.tipo_aplicador', 'Ullamcorper')
                ->selectByName('ropo.tipo_aplicador', 'Ullamcorper')
                ->press('@submit')
                ->assertDontSee('@msg-nombres')
                ->assertDontSee('@msg-apellidos')
                ->assertDontSee('@msg-id_nac')
                ->assertDontSee('@msg-email')
                ->assertDontSee('@msg-tel');

            $browser->visit(new Create)
                ->type('@input-nombres', 'Ipsum')
                ->type('@input-apellidos', 'Nulla')
                ->type('@input-id_nac', '90401911C')
                ->type('@input-email', 'Hendrerit@correo.com')
                ->type('@input-tel', '123-45-67-89')
                ->click('@show-ropo')
                ->assertVisible('#ropo-form')
                ->selectByName('ropo.tipo', 'Técnico')
                ->type('@input-ropo_nro', '167654fdg')
                ->click('@trigger-ropo_caducidad')
                ->pause(1000)
                ->selectByName('ropo.tipo_aplicador', 'Aplicador')
                ->press('@submit')
                ->assertDontSee('@msg-nombres')
                ->assertDontSee('@msg-apellidos')
                ->assertDontSee('@msg-id_nac')
                ->assertDontSee('@msg-email')
                ->assertDontSee('@msg-tel')
                ->assertSeeIn('@msg-ropo_nro', 'El Nº del carnet debe estar en el formato adecuado.');

            $browser->screenshot('persona/create/envio_basico_valido_ropo_invalido');
        });
    }

    /**
     * Test de envío de formulario correcto solo con campos requeridos
     */
    public function testEnvioRequeridosValidos(): void
    {
        $this->browse(function (Browser $browser) {
            $nombres = 'Sadipscing';
            $apellidos = 'Dolore';
            $id_nac = '71709692Q';
            $email = 'Labore@correo.com';

            $instanceByEmail = Persona::where('email', $email);
            $instanceByIdNac = Persona::where('id_nac', $id_nac);

            $instanceByEmail->exists() && $instanceByEmail->delete();
            $instanceByIdNac->exists() && $instanceByIdNac->delete();

            $browser->visit(new Create)
                ->type('@input-nombres', $nombres)
                ->type('@input-apellidos', $apellidos)
                ->type('@input-id_nac', $id_nac)
                ->type('@input-email', $email)
                ->press('@submit')
                ->pause(1000);

            $browser->screenshot('persona/create/formulario_correcto_campos_requeridos');
            $browser->pause(3000)
                ->assertPathEndsWith('recurso/personas');
        });
    }

    /**
     * Test de envío de formulario básico completo correcto
     */
    public function testEnvioBasicosValidos(): void
    {
        $this->browse(function (Browser $browser) {
            $nombres = 'Magna';
            $apellidos = 'Tempor';
            $id_nac = '42841629N';
            $email = 'Iriure@correo.com';
            $tel = '123-45-67-89';
            $obsrv = 'Gubergren rebum et stet at dolor luptatum stet dolor no clita accusam';

            $instanceByEmail = Persona::where('email', $email);
            $instanceByIdNac = Persona::where('id_nac', $id_nac);

            $instanceByEmail->exists() && $instanceByEmail->delete();
            $instanceByIdNac->exists() && $instanceByIdNac->delete();

            $browser->visit(new Create)
                ->type('@input-nombres', $nombres)
                ->type('@input-apellidos', $apellidos)
                ->type('@input-id_nac', $id_nac)
                ->type('@input-email', $email)
                ->type('@input-tel', $tel)
                ->type('@txtarea-observaciones', $obsrv)
                ->press('@submit')
                ->pause(1000);

            $browser->screenshot('persona/create/formulario_basico_completo_correcto');
            $browser->assertPathEndsWith('recurso/personas');
        });
    }

    /**
     * Test de envío de formulario completo correcto
     */
    public function testEnvioCompleto(): void
    {
        $this->browse(function (Browser $browser) {
            $nombres = 'Magna';
            $apellidos = 'Tempor';
            $id_nac = '42841629N';
            $email = 'Iriure@correo.com';
            $tel = '123-45-67-89';
            $obsrv = 'Gubergren rebum et stet at dolor luptatum stet dolor no clita accusam';
            $ropo_tipo = 'Aplicador';
            $ropo_nro = '143038069SU/2';
            $ropo_aplicador = 'Piloto';

            $instanceByEmail = Persona::where('email', $email);
            $instanceByIdNac = Persona::where('id_nac', $id_nac);

            $instanceByEmail->exists() && $instanceByEmail->delete();
            $instanceByIdNac->exists() && $instanceByIdNac->delete();

            $browser->visit(new Create)
                ->type('@input-nombres', $nombres)
                ->type('@input-apellidos', $apellidos)
                ->type('@input-id_nac', $id_nac)
                ->type('@input-email', $email)
                ->type('@input-tel', $tel)
                ->type('@txtarea-observaciones', $obsrv)
                ->click('@show-ropo')
                ->selectByName('ropo.tipo', $ropo_tipo)
                ->type('@input-ropo_nro', $ropo_nro)
                ->click('@trigger-ropo_caducidad')
                ->pause(500)
                ->click('@calendar table tr:nth-child(3) td:nth-child(3)')
                ->pause(1000)
                ->selectByName('ropo.tipo_aplicador', $ropo_aplicador)
                ->press('@submit')
                ->pause(1000);

            $browser->screenshot('persona/create/envio_formulario_completo_correcto');
            $browser->assertPathEndsWith('recurso/personas');
        });
    }
}
