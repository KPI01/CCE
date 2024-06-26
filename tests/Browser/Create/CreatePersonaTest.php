<?php

namespace Tests\Browser;

use App\Models\Persona;
use App\Models\User;
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
    public function testAccesibilidadVisual(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Create)
                ->assertVisible('@form')
                ->assertVisible('@nombres')
                ->assertVisible('@apellidos')
                ->assertVisible('@tipo_id_nac')
                ->assertVisible('@id_nac')
                ->assertVisible('@email')
                ->assertVisible('@tel')
                ->assertVisible('@observaciones')
                ->assertVisible('@submit')
                ->assertVisible('@reset')
                ->within(new Navbar, function (Browser $browser) {
                    $userNombre = $this->user->nombres;
                    $browser->assertSeeIn('@titulo', "Bienvenido, $userNombre")
                        ->assertVisible('@home-btn')
                        ->assertVisible('@conf-btn')
                        ->assertVisible('@nav')
                        ->assertVisible('@list')
                        ->assertVisible('@rsrc-btn');
                });

            $browser->screenshot('persona/create/accesibilidad_visual');
        });
    }

    /**
     * Test de visualizar todos los campos
     */
    public function testAccesibilidadCompleta(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Create)
                ->assertVisible('@form')
                ->assertVisible('@nombres')
                ->assertVisible('@apellidos')
                ->assertVisible('@tipo_id_nac')
                ->assertVisible('@id_nac')
                ->assertVisible('@email')
                ->assertVisible('@tel')
                ->assertVisible('@observaciones')
                ->assertVisible('@ropo-checkbox-btn')
                ->click('@ropo-checkbox-btn')
                ->assertVisible('@ropo-form')
                ->assertVisible('@ropo.tipo')
                ->assertVisible('@ropo.caducidad-btn')
                ->assertEnabled('@ropo.caducidad-btn')
                ->assertVisible('@ropo.caducidad-value')
                ->press('@ropo.caducidad-btn')
                ->assertVisible('@ropo.caducidad-calendar')
                ->assertVisible('@ropo.nro')
                ->assertVisible('@ropo.tipo_aplicador')
                ->assertVisible('@submit')
                ->assertVisible('@reset');

            $browser->screenshot('persona/create/accesibilidad_completa');
        });
    }

    /**
     * Test de llenado de campos básicos
     */
    public function testLlenadoCamposBasicos(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Create)
                ->type('@nombres', 'Prueba')
                ->assertInputValue('@nombres', 'Prueba')
                ->type('@apellidos', 'Prueba')
                ->assertInputValue('@apellidos', 'Prueba')
                ->select('@tipo_id_nac', 'DNI')
                ->assertSelected('@tipo_id_nac', 'DNI')
                ->type('@id_nac', 'A12345678')
                ->assertInputValue('@id_nac', 'A12345678')
                ->type('@email', 'prueba@prueba')
                ->assertInputValue('@email', 'prueba@prueba')
                ->type('@tel', '123-456-78-90')
                ->assertInputValue('@tel', '123-456-78-90')
                ->type('@observaciones', 'Prueba')
                ->assertInputValue('@observaciones', 'Prueba')
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
                ->type('@nombres', 'Prueba')
                ->assertInputValue('@nombres', 'Prueba')
                ->type('@apellidos', 'Prueba')
                ->assertInputValue('@apellidos', 'Prueba')
                ->select('@tipo_id_nac', 'DNI')
                ->assertSelected('@tipo_id_nac', 'DNI')
                ->type('@id_nac', 'A12345678')
                ->assertInputValue('@id_nac', 'A12345678')
                ->type('@email', 'prueba@prueba')
                ->assertInputValue('@email', 'prueba@prueba')
                ->type('@tel', '123-456-78-90')
                ->assertInputValue('@tel', '123-456-78-90')
                ->type('@observaciones', 'Prueba')
                ->assertInputValue('@observaciones', 'Prueba')
                ->click('@ropo-checkbox-btn')
                ->assertChecked('@ropo-checkbox')
                ->assertVisible('@ropo-form')
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
                ->type('@nombres', 'Prueba')
                ->assertInputValue('@nombres', 'Prueba')
                ->type('@apellidos', 'Prueba')
                ->assertInputValue('@apellidos', 'Prueba')
                ->select('@tipo_id_nac', 'DNI')
                ->assertSelected('@tipo_id_nac', 'DNI')
                ->type('@id_nac', 'A12345678')
                ->assertInputValue('@id_nac', 'A12345678')
                ->type('@email', 'prueba@prueba')
                ->assertInputValue('@email', 'prueba@prueba')
                ->type('@tel', '123-456-78-90')
                ->assertInputValue('@tel', '123-456-78-90')
                ->select('@perfil', 'Supervisor')
                ->assertSelected('@perfil', 'Supervisor')
                ->type('@observaciones', 'Prueba')
                ->assertInputValue('@observaciones', 'Prueba')
                ->click('@ropo-checkbox-btn')
                ->assertChecked('@ropo-checkbox')
                ->select('@ropo.tipo', 'Aplicador')
                ->assertSelected('@ropo.tipo', 'Aplicador')
                ->type('@ropo.nro', '123456789')
                ->assertInputValue('@ropo.nro', '123456789')
                ->select('@ropo.tipo_aplicador', 'Piloto')
                ->assertSelected('@ropo.tipo_aplicador', 'Piloto')
                ->screenshot('persona/create/llenado_completo');
        });
    }

    /**
     * Test de envío de campos requeridos vacíos
     */
    public function testEnvioVacio(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Create)
                ->click('@submit')
                ->assertSeeIn('@nombres-message', 'Este campo es requerido.')
                ->assertSeeIn('@apellidos-message', 'Este campo es requerido.')
                ->assertSeeIn('@id_nac-message', 'Este campo es requerido.')
                ->assertSeeIn('@email-message', 'Este campo es requerido.')
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
                ->type('@nombres', 'At')
                ->type('@apellidos', 'Ut')
                ->type('@id_nac', '2Q864422J0AK3')
                ->type('@email', 'Eirmod.com')
                ->press('@submit')
                ->assertSeeIn('@nombres-message', 'El nombre debe tener al menos 3 caracteres.')
                ->assertSeeIn('@apellidos-message', 'Los apellidos deben tener al menos 3 caracteres.')
                ->assertSeeIn('@id_nac-message', 'El DNI/NIE debe ser de 12 caracteres.')
                ->assertSeeIn('@email-message', 'El correo debe ser válido.')
                ->screenshot('persona/create/requeridos_invalidos_1');

            $browser->visit(new Create)
                ->type('@nombres', 'Accumsan tempor clita voluptua diam diam et invidunt ut dolor amet commodo')
                ->type('@apellidos', 'Tempor gubergren eos eirmod diam vel gubergren sadipscing euismod nonummy nonumy tincidunt')
                ->type('@id_nac', '7D1BJ11O3VRH76YH')
                ->type('@email', 'Sadipscing.com')
                ->press('@submit')
                ->assertSeeIn('@nombres-message', 'El nombre debe tener menos de 50 caracteres.')
                ->assertSeeIn('@apellidos-message', 'Los apellidos deben tener menos de 50 caracteres.')
                ->assertSeeIn('@id_nac-message', 'El DNI/NIE debe ser de 12 caracteres.')
                ->assertSeeIn('@email-message', 'El correo debe ser válido.')
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
                ->type('@nombres', 'Veniam')
                ->type('@apellidos', 'Tempor')
                ->type('@id_nac', '04315370H')
                ->type('@email', 'Accusam@correo.com')
                ->type('@tel', '123456789')
                ->press('@submit')
                ->assertDontSee('@nombres-message')
                ->assertDontSee('@apellidos-message')
                ->assertDontSee('@id_nac-message')
                ->assertDontSee('@email-message')
                ->assertSeeIn('@tel-message', 'El número debe estar en el formato indicado.');

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
                ->type('@nombres', 'Ipsum')
                ->type('@apellidos', 'Nulla')
                ->type('@id_nac', '90401911C')
                ->type('@email', 'Hendrerit@correo.com')
                ->type('@tel', '123-45-67-89')
                ->click('@ropo-checkbox-btn')
                ->assertVisible('@ropo-form')
                ->assertSelectMissingOption('@ropo.tipo', 'Volutpat')
                ->assertSelectHasOption('@ropo.tipo', 'Aplicador')
                ->assertSelectHasOption('@ropo.tipo', 'Técnico')
                ->select('@ropo.tipo', 'Aplicador')
                ->type('@ropo.nro', '16789KJH&%@$')
                ->press('@ropo.caducidad-btn')
                ->assertVisible('@ropo.caducidad-calendar')
                // ->click('@ropo.caducidad-calendar table tbody tr:last-child td:last-child')
                // ->assertInputValue('@ropo.caducidad-input', '2024-06-30')
                ->value('@ropo.caducidad-input', '30-06-2024')
                ->assertSelectMissingOption('@ropo.tipo_aplicador', 'Ullamcorper')
                ->assertSelectHasOption('@ropo.tipo_aplicador', 'Básico')
                ->assertSelectHasOption('@ropo.tipo_aplicador', 'Cualificado')
                ->assertSelectHasOption('@ropo.tipo_aplicador', 'Fumigación')
                ->assertSelectHasOption('@ropo.tipo_aplicador', 'Piloto')
                ->assertSelectHasOption('@ropo.tipo_aplicador', 'Aplicación Fitosanitarios')
                ->select('@ropo.tipo_aplicador', 'Piloto')
                ->press('@submit')
                ->assertDontSee('@nombres-message')
                ->assertDontSee('@apellidos-message')
                ->assertDontSee('@id_nac-message')
                ->assertDontSee('@email-message')
                ->assertDontSee('@tel-message')
                ->assertSeeIn('@ropo.nro-message', 'El Nº del carnet debe estar en el formato adecuado.');

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
                ->type('@nombres', $nombres)
                ->type('@apellidos', $apellidos)
                ->type('@id_nac', $id_nac)
                ->type('@email', $email)
                ->press('@submit')
                ->pause(1000);

            $browser->screenshot('persona/create/formulario_correcto_campos_requeridos');
            $browser->assertPathEndsWith('recurso/personas');
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
                ->type('@nombres', $nombres)
                ->type('@apellidos', $apellidos)
                ->type('@id_nac', $id_nac)
                ->type('@email', $email)
                ->type('@tel', $tel)
                ->type('@observaciones', $obsrv)
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
            $ropo_caducidad = '2024-12-31';
            $ropo_aplicador = 'Piloto';

            $instanceByEmail = Persona::where('email', $email);
            $instanceByIdNac = Persona::where('id_nac', $id_nac);

            $instanceByEmail->exists() && $instanceByEmail->delete();
            $instanceByIdNac->exists() && $instanceByIdNac->delete();

            $browser->visit(new Create)
                ->type('@nombres', $nombres)
                ->type('@apellidos', $apellidos)
                ->type('@id_nac', $id_nac)
                ->type('@email', $email)
                ->type('@tel', $tel)
                ->type('@observaciones', $obsrv)
                ->click('@ropo-checkbox-btn')
                ->select('@ropo.tipo', $ropo_tipo)
                ->type('@ropo.nro', $ropo_nro)
                ->value('@ropo.caducidad-input', $ropo_caducidad)
                ->select('@ropo.tipo_aplicador', $ropo_aplicador)
                ->press('@submit')
                ->pause(1000);

            $browser->screenshot('persona/create/envio_formulario_completo_correcto');
            $browser->assertPathEndsWith('recurso/personas');
        });
    }
}
