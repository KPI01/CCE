<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\NoAuth\NavBar;
use Tests\Browser\Pages\NoAuth\ResetPassword;
use Tests\DuskTestCase;

class ResetPasswordTest extends DuskTestCase
{
    /**
     * Test de accesibilidad y visibilidad de la página.
     */
    public function testAccesibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new ResetPassword)
                ->within(new NavBar, function (Browser $browser) {
                        $browser->assertSeeIn('@title', 'Cuaderno de Campo Electrónico');
                        $browser->assertSeeIn('@button', 'Volver');
                });

            $browser->assertVisible('@form')
                ->assertVisible('@email')
                ->assertVisible('@submit-email');

            $browser->screenshot('reset-password/accesibilidad');
        });
    }

    /**
     * Test de envío de email vacío.
     */
    public function testEnviarCorreoVacio(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new ResetPassword);

            $browser->press('@submit-email')
                ->assertSee('Debes ingresar un correo.');

            $browser->screenshot('reset-password/correo_vacio');
        });
    }

    public function testCorreoInvalido(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new ResetPassword);

            $browser->type('@email', 'informatica@')
                ->press('@submit-email')
                ->assertSee('El correo debe ser válido.');

            $browser->screenshot('reset-password/correo_invalido');
        });
    }
}
