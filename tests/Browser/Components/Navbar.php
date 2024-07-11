<?php

namespace Tests\Browser\Components;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class Navbar extends BaseComponent
{
    /**
     * Get the root selector for the component.
     */
    public function selector(): string
    {
        return "#navbar";
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
            "@titulo" => "h2",
            "@nav" => "#navbar-nav",
            "@list" => "#navbar-nav-list",
            "@rcs-btn" => "#navbar-rsrc button",
            "@rcs-list" => "#rsrc-content #rsrc-list",
            "@conf-btn" => "#navbar-conf",
            "@conf-menu" => "#navbar-conf + div",
            "@home-btn" => 'div a[href*="app/home"]',
            "@logout" => "#navbar-conf + div a",
        ];
    }
}
