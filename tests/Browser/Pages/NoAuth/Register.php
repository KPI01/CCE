<?php

namespace Tests\Browser\Pages\NoAuth;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class Register extends Page
{
    /**
     * Obtener la URL de la página.
     */
    public function url(): string
    {
        return '/cce/auth/registro';
    }

    /**
     * Aserción que el navegador está en la página.
     */
    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Shortcuts para elementos de la página.
     *
     * @return array<string, string>
     */
    public function elements(): array
    {
        return [
            '@form' => '#app main form',
            '@name' => '#app main form input[name="name"]',
            '@email' => '#app main form input[name="email"]',
            '@pass' => '#app main form input[name="password"]',
            '@pass-toggle' => '#app main form button[id="show-password"]',
            '@confirm-pass' => '#app main form input[name="confirmPassword"]',
            '@confirm-toggle' => '#app main form button[id="show-confirmPassword"]',
            '@submit' => '#app main form button[type="submit"]',
        ];
    }
}
