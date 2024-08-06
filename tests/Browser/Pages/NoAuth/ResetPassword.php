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
        return "/cce/auth/clave/olvido";
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
            "@card-title" => "h3",
            "@card-description" => "h3 + p",
            "@form" => "#app main form",
            "@email" => '#app main form input[name="email"]',
            "@submit-email" =>
                '#app main form button[type="submit"]#submit-email',
        ];
    }
}
