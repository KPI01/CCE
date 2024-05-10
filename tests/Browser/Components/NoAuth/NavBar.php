<?php

namespace Tests\Browser\Components\NoAuth;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class NavBar extends BaseComponent
{
    /**
     * Get the root selector for the component.
     */
    public function selector(): string
    {
        return 'nav';
    }

    /**
     * Assert that the browser page contains the component.
     */
    public function assert(Browser $browser): void
    {
        $browser->assertVisible($this->selector());
    }

    /**
     * Get the element shortcuts for the component.
     *
     * @return array<string, string>
     */
    public function elements(): array
    {
        return [
            '@nav' => $this->selector(),
            '@nav-title' => $this->selector() . ' h1',
            '@nav-link' => $this->selector() . ' a',
        ];
    }
}
