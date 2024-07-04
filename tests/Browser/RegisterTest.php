<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\NoAuth\NavBar;
use Tests\Browser\Pages\NoAuth\Register;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    /**
     * Test de accesibilidad y visibilidad de la página.
     */
    public function testAccesibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Register())
                ->within(new NavBar(), function (Browser $browser) {
                    $browser
                        ->assertSeeIn("@title", "Cuaderno de Campo Electrónico")
                        ->assertSeeIn("@button", "Iniciar sesión");
                });

            $browser
                ->assertVisible("@form")
                ->assertVisible("@name")
                ->assertVisible("@email")
                ->assertVisible("@pass")
                ->assertVisible("@pass-toggle")
                ->assertVisible("@confirm-pass")
                ->assertVisible("@confirm-toggle")
                ->assertVisible("@submit");

            $browser->screenshot("register/accesibilidad");
        });
    }

    /**
     * Test de envío de campos vacíos
     */
    public function testCamposVacios(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Register());

            $browser
                ->press("@submit")
                ->assertSee("Debes ingresar un nombre.")
                ->assertSee("Debes ingresar un correo.")
                ->assertSee(
                    "La clave debe tener al menos 1 mayúscula, 1 minúscula, 1 número, 1 símbolo y al menos 8 caracteres."
                );

            $browser->screenshot("register/campos_vacios");
        });
    }

    /**
     * Test de envío de campos inválidos
     */
    public function testCamposInvalidos(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Register());

            $browser
                ->type("@name", "Informatica1")
                ->type("@email", "informatica7/")
                ->type("@pass", "123456")
                ->type("@confirm-pass", "1234567")
                ->press("@submit");

            $browser
                ->assertSee("El nombre solo puede contener letras.")
                ->assertSee("Debes ingresar un correo")
                ->assertSee(
                    "La clave debe tener al menos 1 mayúscula, 1 minúscula, 1 número, 1 símbolo y al menos 8 caracteres."
                )
                ->assertSee("Las claves deben coincidir.");

            $browser->screenshot("register/campos_invalidos");
        });
    }

    /**
     * Test de visibilidad de claves
     */
    public function testVisibilidadClaves(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Register());

            $browser
                ->type("@name", "Jorge")
                ->type("@email", "jorge@correo.com");

            $browser
                ->assertAttribute("@pass", "type", "password")
                ->assertAttribute("@confirm-pass", "type", "password");

            $browser
                ->type("@pass", "123456")
                ->type("@confirm-pass", "123456")
                ->press("@pass-toggle")
                ->press("@confirm-toggle");

            $browser
                ->assertAttribute("@pass", "type", "text")
                ->assertAttribute("@confirm-pass", "type", "text");

            $browser->screenshot("register/visibilidad_claves");
        });
    }

    /**
     * Test con campos correctos
     */
    public function testCamposCorrectos(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Register());

            $browser
                ->type("@name", "Jorge")
                ->type("@email", "jorge@correo.com")
                ->type("@pass", "FKH!9NB%Bj")
                ->click("@pass-toggle")
                ->type("@confirm-pass", "FKH!9NB%Bj")
                ->press("@submit");

            $browser
                ->assertDontSee("El nombre solo puede contener letras.")
                ->assertDontSee("El correo debe ser válido.")
                ->assertDontSee(
                    "La clave debe tener al menos 1 mayúscula, 1 minúscula, 1 número, 1 símbolo y al menos 8 caracteres."
                )
                ->assertDontSee("Las claves deben coincidir.");

            $browser->screenshot("register/envio_formulario");
        });
    }
}
