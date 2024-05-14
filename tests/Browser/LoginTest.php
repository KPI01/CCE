<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\NoAuth\NavBar;
use Tests\Browser\Pages\NoAuth\Login;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * Test de acceso y visibilidad de la página.
     */
    public function testAccesibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                ->within(new NavBar, function (Browser $browser) {
                    $browser->assertSeeIn('@title', 'Cuaderno de Campo Electrónico')
                        ->assertSeeIn('@button', 'Regístrate');

                });

            $browser->assertVisible('@form')
                ->assertVisible('@email')
                ->assertVisible('@pass')
                ->assertVisible('@toggle-visibility')
                ->assertVisible('@reset-link')
                ->assertVisible('@submit');

            $browser->screenshot('login/accesibilidad');
        });
    }

    /**
     * Test de ir a la página de registro.
     */
    public function testIrRegistro(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login)
                ->within(new NavBar, function (Browser $browser) {
                    $browser->assertVisible('@button')
                        ->assertSeeLink('Regístrate');

                    $browser->clickLink('Regístrate');
                });

            $browser->screenshot('login/ir_registro');
        });
    }

    /**
     * Test de envío de campos vacíos.
     */
    public function testEnviarCamposVacios(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login);

            $browser->press('@submit');

            $browser->assertSee('Debes ingresar tu correo.')
                ->assertSee('Debes ingresar tu clave.');

            $browser->screenshot('login/campos_vacíos');
        });
    }

    /**
     * Test de envío de campos incorrectos
     */
    public function testEnviarCamposIncorrectos(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login);

            $browser->type('@email', 'informatica@')
                ->type('@pass', '123456')
                ->press('@submit');

            $browser->assertSee('Debes ingresar tu correo.')
                ->assertSee('La clave debe tener al menos 8 caracteres.');

            $browser->screenshot('login/campos_incorrectos');
        });
    }

    /**
     * Visibilidad de clave
     */
    public function testVisibilidadClave(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login);

            $browser->assertAttribute('@pass', 'type', 'password');

            $browser->type('@pass', '123456')
                ->click('@toggle-visibility');

            $browser->assertAttribute('@pass', 'type', 'text');

            $browser->screenshot('login/visibilidad_clave');
        });
    }

    /**
     * Test de envío de datos de usuario Informatica
     */
    public function testUsuarioInformatica(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login);

            $browser->type('@email','informatica@fruveco.com')
                ->type('@pass', 'Fruveco@2024')
                ->press('@submit');

            $browser->assertDontSee('Debes ingresar tu correo.')
                ->assertDontSee('Debes ingresar tu clave.');

            $browser->screenshot('login/usuario_informatica');
        });
    }
}
