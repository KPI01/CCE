<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\NoAuth\NavBar;
use Tests\Browser\Pages\NoAuth\Login as NoAuthLogin;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{

    /**
     * Test de acceso.
     */
    public function testAcceso(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new NoAuthLogin)
                ->screenshot('login/acceso');
        });
    }
}
