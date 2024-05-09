<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testBasic(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/cce/auth/registro')
                ->assertVisible('#app')
                ->assertVisible('#app > nav')
                ->assertVisible('#app > nav a[href*="cce"]')
                ->assertVisible('#app > * > main')
                ->assertVisible('#app > * > main form');

            $browser->assertPathIs('/cce/auth/registro');

            $browser->assertTitleContains('Registro | CCE');

            $browser->assertSeeAnythingIn('h1', 'Cuaderno de Campo Electrónico');
            $browser->assertSeeIn('a[href*="cce"]', 'Iniciar sesión!');

            $browser->assertSee('Registro');
            $browser->assertSee('Para poder registrar al usuario ingresa los datos adecuadamente');

            $browser->assertPathIs('/cce/auth/registro');

            $browser->inputValue('name', 'Jorge');
            $browser->inputValue('email', 'jorge@jorge.com');
            $browser->inputValue('password', '123456');
            $browser->click('button[type=button]#show-password');
            $browser->inputValue('confirmPassword', '123456');
            $browser->click('button[type=button]#show-confirmPassword');
            $browser->click('button[type=submit]');
        });
    }
}
