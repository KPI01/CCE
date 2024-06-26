<?php

namespace Tests\Browser\Pages\Recursos\Persona;

use Illuminate\Http\Request;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class Table extends Page
{
    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        $url = Request::create(route('personas.index'));
        return '/'.$url->path();
    }

    /**
     * Assert that the browser is on the page.
     */
    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array<string, string>
     */
    public function elements(): array
    {
        return [
            '@header-' => '#header-',
            '@filtros-' => '#filtros-',
            '@visibilidad-' => '#visibilidad-',
            '@v-toggle-' => '#visibilidad-content #toggle-col-',
            '@datatable' => '#data-table',
            '@page-' => '#page-',
            '@goTo-' => '#goto-',
        ];
    }
}
