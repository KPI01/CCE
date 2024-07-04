<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\NoAuth\NavBar;
use Tests\Browser\Pages\NoAuth\Login;
use Tests\Browser\Pages\NoAuth\ResetPassword;
use Tests\DuskTestCase;

class ResetPasswordTest extends DuskTestCase
{
    /**
     * Acceso a la página desde el login.
     */
    public function testAccesoDesdeLogin(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Login())
                ->within("#app div form", function (Browser $browser) {
                    $browser->screenshot("reset_pass/acceso_login_1");
                    $browser
                        ->assertSee("¿Clave olvidada?")
                        ->clickLink("¿Clave olvidada?")
                        ->pause(1000)
                        ->assertPathIs("/cce/auth/clave/olvido");
                });

            $browser
                ->screenshot("reset_pass/acceso_login_2")
                ->storeConsoleLog("reset_pass/acceso_login");
        });
    }

    /**
     * Test de volver al login
     */
    public function testVolverLogin(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new ResetPassword())
                ->screenshot("reset_pass/volver_login_1")
                ->within(new NavBar(), function (Browser $browser) {
                    $browser
                        ->clickLink("Volver al inicio de sesión")
                        ->pause(1000)
                        ->assertPathIs("/cce/auth/login");
                })
                ->screenshot("reset_pass/volver_login_2");
        });
    }

    /**
     * Test de accesibilidad y visibilidad de la página.
     */
    public function testAccesibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new ResetPassword())
                ->within(new NavBar(), function (Browser $browser) {
                    $browser
                        ->assertSeeIn("@title", "Cuaderno de Campo Electrónico")
                        ->assertSeeIn("@button", "Volver al inicio de sesión");
                });

            $browser
                ->assertVisible("@card-title")
                ->assertVisible("@card-description")
                ->assertVisible("@form")
                ->assertVisible("@email")
                ->assertVisible("@submit-email");

            $browser
                ->screenshot("reset_pass/accesibilidad")
                ->storeConsoleLog("reset_pass/accesibilidad");
        });
    }

    /**
     * Test de envío con campo vacío
     */
    public function testCampoVacio(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new ResetPassword());

            $browser
                ->press("@submit-email")
                ->assertSeeIn("@email + p", "Correo inválido.");

            $browser
                ->screenshot("reset_pass/campo_vacio")
                ->storeConsoleLog("reset_pass/campo_vacio");
        });
    }

    /**
     * Test de envío de correo en formato inválido.
     */
    public function testCorreoInvalido(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new ResetPassword());

            $browser->type("@email", "mal_correo%.com")->press("@submit-email");

            $browser->assertSeeIn("@email + p", "Correo inválido.");

            $browser
                ->screenshot("reset_pass/correo_invalido")
                ->storeConsoleLog("reset_pass/correo_invalido");
        });
    }

    /**
     * Test de envío de correo adecuadamente
     */
    public function testEnvioCorreo(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new ResetPassword());

            $browser
                ->type("@email", "informatica@fruveco.com")
                ->press("@submit-email")
                ->assertDontSee("Correo inválido.")
                ->pause(1000);

            $browser
                ->screenshot("reset_pass/correo_adecuado")
                ->storeConsoleLog("reset_pass/correo_adecuado");
        });
    }
}
