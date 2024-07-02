<?php

namespace Tests\Browser\Pages\Recursos\Persona;

use Illuminate\Http\Request;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class Create extends Page
{
    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        //
        $url = Request::create(route('personas.create'));
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
            '@form' => 'form#create-persona-form',
            '@back' => 'button#back',
            '@input-' => 'input#input-',
            '@txtarea-observaciones' => 'textarea[name=observaciones]#input-observaciones',
            '@msg-' => 'p#msg-',
            '@calendar' => 'div#calendar-ropo_caducidad',
            '@trigger-' => 'button#trigger-',
            '@label-' => 'label#label-',
            '@submit' => 'button[type="submit"]',
            '@reset' => 'button[type="reset"]',
            '@show-ropo' => 'button#show-ropo',
        ];
    }
}
