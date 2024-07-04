<?php

namespace Tests\Browser\Pages\Recursos\Persona;

use App\Models\Persona;
use Illuminate\Http\Request;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class Show extends Page
{
    public $p;

    public function __construct(Persona $instance)
    {
        $this->p = $instance;
    }

    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        $url = Request::create(route("personas.show", $this->p->id));
        return "/" . $url->path();
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
            "@form" => "form#show-form-" . $this->p->id,
            "@h3-" => "h3#h3-",
            "@separator" => 'div[data-orientation="horizontal"]',
            "@input-" => "input#input-",
            "@trigger-" => "button#trigger-",
            "@label-" => "label#label-",
            "@txt-observaciones" =>
                "textarea[name=observaciones]#input-observaciones",
        ];
    }
}
