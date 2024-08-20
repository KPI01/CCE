<?php

namespace Tests\Browser\Pages\Recursos;

use Illuminate\Http\Request;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class Table extends Page
{
    protected string $r;

    public function __construct(string $recurso)
    {
        $this->r = $recurso;
    }

    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        $route = Request::create(route("$this->r.index"));
        return "/" . $route->path();
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
            "@container" => "#dt-container",
            "@dt" => "#dt-container table",
            "@thead" => "#dt-container table thead",
            "@tbody" => "#dt-container table tbody",
            "@v-" => "#visibilidad-",
            "@tog-col" => "#toggle-col-",
            "@f-" => "#filtros-",
            "@p-" => "#pag-",
            "@pag-" => "#pag-nav-",
            "@radix-popper" => "div[data-radix-popper-content-wrapper]",
            "@radix-item" => "div[data-radix-collection-item]",
            "@radix-menu-item-checkbox" => "div[role=menuitemcheckbox]",
            "@r-menu" => "table tbody tr:first-child td:last-child button",
            "@acc-show" => "a[id^=action-show]",
            "@acc-edit" => "a[id^=action-edit]",
            "@acc-destroy" => "button[id^=action-destroy]",
            "@acc-create" => "button#action-create",
            "@p-pri" => "button#pag-nav-primera",
            "@p-ant" => "button#pag-nav-anterior",
            "@p-sig" => "button#pag-nav-siguiente",
            "@p-ult" => "button#pag-nav-ultima",
        ];
    }
}
