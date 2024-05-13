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
     * Test de envío de campos vacíos.
     */
    public function testEnviarCamposVacios(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login);

            $browser->press('@submit');

            $browser->assertSee('Debes ingresar un correo.')
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

            $browser->assertSee('Debes ingresar un correo válido.')
                ->assertSee('La clave debe tener al menos 1 mayúscula, 1 minúscula, 1 número y 1 símbolo.');

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
}
