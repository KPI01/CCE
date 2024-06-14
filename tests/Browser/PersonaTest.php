<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\Recursos\Persona\Create;
use Tests\DuskTestCase;

class PersonaTest extends DuskTestCase
{
    public $user;

    public function setUp(): void
    {
        parent::setUp();
        // Login como informatica
        $this->user = User::where('email', 'informatica@fruveco.com')->first();
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user);
        });
    }

    /**
     * Comprobación que se puede acceder.
     */
    public function test_acceso_pagina(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Create);

            $browser->screenshot('persona/create/acceso_pagina');
        });
    }

    /**
     * Comprobación de visualización de elementos
     */
    public function test_visualizar_elementos_basicos(): void
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

            $browser->screenshot('persona/create/visualizar_elementos');
        });
    }

    /**
     * Test de visualizar todos los campos
     */
    public function test_visualizar_todos_los_campos(): void
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
                ->assertVisible('@ropo.caducidad-input')
                ->assertVisible('@ropo.caducidad-trigger')
                ->click('@ropo.caducidad-trigger')
                ->assertVisible('@ropo.caducidad-calendar')
                ->assertVisible('@ropo.nro')
                ->assertVisible('@ropo.tipo_aplicador')
                ->assertVisible('@submit')
                ->assertVisible('@reset');
        });
    }

    /**
     * Test de llenado de campos basicos
     */
    public function test_llenar_campos_basicos(): void
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
                ->screenshot('persona/create/llenar_campos_basicos');
        });
    }

    /**
     * Test para mostrar el formulario completo
     */
    public function test_mostrar_campos_completos(): void
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
                ->screenshot('persona/create/llenar_formulario_completo');
        });
    }

    /**
     * Test de llenado de formulario completo
     */
    public function test_llenar_formulario_completo(): void
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
                ->keys('@ropo.caducidad-input', '31122024')
                ->assertInputValue('@ropo.caducidad-input', '2024-12-31')
                ->select('@ropo.tipo_aplicador', 'Piloto')
                ->assertSelected('@ropo.tipo_aplicador', 'Piloto')
                ->screenshot('persona/create/llenar_formulario_completo');
        });
    }

    /**
     * Test de envío de campos requeridos vacíos
     */
    public function test_campos_requeridos_vacios(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Create)
                ->click('@submit')
                ->assertSeeIn('@nombres-err', 'Este campo es requerido.')
                ->assertSeeIn('@apellidos-err', 'Este campo es requerido.')
                ->assertSeeIn('@id_nac-err', 'Este campo es requerido.')
                ->assertSeeIn('@email-err', 'Este campo es requerido.')
                ->screenshot('persona/create/campos_requeridos_vacios');
        });
    }

    /**
     * Test de envío de campos requeridos inválidos
     */
    public function test_campos_requeridos_invalidos(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Create)
                ->type('@nombres', 'At')
                ->type('@apellidos', 'Ut')
                ->type('@id_nac', '2Q864422J0AK3')
                ->type('@email', 'Eirmod.com')
                ->press('@submit')
                ->assertSeeIn('@nombres-err', 'El nombre debe tener al menos 3 caracteres.')
                ->assertSeeIn('@apellidos-err', 'Los apellidos deben tener al menos 3 caracteres.')
                ->assertSeeIn('@id_nac-err', 'El DNI/NIE debe ser de 12 caracteres.')
                ->assertSeeIn('@email-err', 'El correo debe ser válido.')
                ->screenshot('persona/create/campos_requeridos_invalidos_1');

            $browser->visit(new Create)
                ->type('@nombres', 'Accumsan tempor clita voluptua diam diam et invidunt ut dolor amet commodo')
                ->type('@apellidos', 'Tempor gubergren eos eirmod diam vel gubergren sadipscing euismod nonummy nonumy tincidunt')
                ->type('@id_nac', '7D1BJ11O3VRH')
                ->type('@email', 'Sadipscing.com')
                ->press('@submit')
                ->assertSeeIn('@nombres-err', 'El nombre debe tener menos de 50 caracteres.')
                ->assertSeeIn('@apellidos-err', 'Los apellidos deben tener menos de 50 caracteres.')
                ->assertSeeIn('@id_nac-err', 'El DNI/NIE debe ser de 12 caracteres.')
                ->assertSeeIn('@email-err', 'El correo debe ser válido.')
                ->screenshot('persona/create/campos_requeridos_invalidos_2');
        });
    }
}
