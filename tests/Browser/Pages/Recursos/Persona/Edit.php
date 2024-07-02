<?php

namespace Tests\Browser\Pages\Recursos\Persona;

use App\Models\Persona;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;
use Illuminate\Http\Request;

class Edit extends Page
{
    public $inst;

    public function __construct(Persona $inst)
    {
        $this->inst = $inst;
    }

    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        //
        $url = Request::create(route('personas.edit', $this->inst->id));
        return '/' . $url->path();
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
            '@form' => 'form#edit-form-' . $this->inst->id,
            '@h3-' => 'h3#h3-',
            '@separator' => 'div[data-orientation="horizontal"]',
            '@input-' => 'input#input-',
            '@trigger-' => 'button#trigger-',
            '@label-' => 'label#label-',
            '@txt-observaciones' => 'textarea[name=observaciones]#input-observaciones',
            '@submit' => 'button[type="submit"]',
            '@msg-' => 'p#msg-',
            '@calendar' => 'div#calendar-ropo_caducidad',
        ];
    }
}
