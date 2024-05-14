<?php

namespace Tests\Browser\Pages\NoAuth;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class ResetPassword extends Page
{
    /**
     * Obtención de la URL de la página.
     */
    public function url(): string
    {
        return '/cce/auth/reset';
    }

    /**
     * Aserción de que el navegador está en la página.
     */
    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Shortcuts para los elementos de la página.
     *
     * @return array<string, string>
     */
    public function elements(): array
    {
        return [
            '@form' => '#app main form',
            '@email' => '#app main form input[name="email"]',
            '@submit-email' => '#app main form button[type="submit"]#btn-email',
        ];
    }
}
