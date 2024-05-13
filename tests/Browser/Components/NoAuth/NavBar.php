<?php

namespace Tests\Browser\Components\NoAuth;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class NavBar extends BaseComponent
{
    /**
     * Obtener el elemento base.
     */
    public function selector(): string
    {
        return '#app > nav';
    }

    /**
     * Aserción que la página contiene el componente.
     */
    public function assert(Browser $browser): void
    {
        $browser->assertVisible($this->selector());
    }

    /**
     * Shortcuts para los elementos del componente.
     *
     * @return array<string, string>
     */
    public function elements(): array
    {
        return [
            '@title' => 'h1',
            '@button' => 'a',
        ];
    }
}
