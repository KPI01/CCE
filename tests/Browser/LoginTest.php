<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testBasic(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/cce/auth/login')
                ->assertVisible('#app')
                ->assertVisible('#app > nav')
                ->assertVisible('#app > nav a[href*="cce"]')
                ->assertVisible('#app > * > main')
                ->assertVisible('#app > * > main form');
                
            $browser->assertPathIs('/cce/auth/login');

            $browser->assertTitle('Inicio de Sesión | CCE');

            $browser->assertSeeIn('h1', 'Cuaderno de Campo Electrónico');
            $browser->assertSeeIn('a[href*="auth"]', 'Regístrate!');

            $browser->assertSee('Inicio de Sesión');
            $browser->assertSee('Para poder utilizar la aplicación, primero debes identificarte.');
        });
    }
}
