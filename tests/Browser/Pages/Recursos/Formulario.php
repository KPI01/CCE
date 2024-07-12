<?php

namespace Tests\Browser\Pages\Recursos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class Formulario extends Page
{
    private string $rcs;
    private string $acc;
    private Model $inst;

    public function __construct(
        string $recurso,
        string $accion,
        Model $modelo = null
    ) {
        echo "__construct: Formulario";        
        if (!in_array($accion, ["show", "edit", "create"])) {
            echo "Acción no válida";
            $arr_str = implode(", ", ["show", "edit", "create"]);
            report("La acción debe ser alguna de las siguientes: $arr_str");
        }

        $this->rcs = $recurso;
        $this->acc = $accion;
        $this->inst = $modelo;
    }
    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        $accion = implode(".", [$this->rcs, $this->acc]);
        (in_array($this->acc, ["edit", "show"]) && isset($this->inst))
            ? ($rt = Request::create(
                route($accion, $this->inst->id)
            ))
            : ($rt = Request::create(route($accion)));
        echo "url: " . $rt->path() . PHP_EOL;

        return "/" . $rt->path();
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
            "@alertdialog" => 'div[role="alertdialog"]',
            "@switch" => 'button[type="button"][role="switch"]',
            "@badge-" => "#badge-",
            "@form-" => "form#",
            "@h3-" => "h3#h3-",
            "@label-" => "label#label-",
            "@input-" => "input#input-",
            "@txt-" => "textarea#input-",
            "@descrip-" => "p#descrip-",
            "@calendar" => "div#calendar-ropo_caducidad",
            "@msg-" => "p#msg-",
            "@trigger-" => "button#trigger-",
            "@submit" => 'button[type="submit"]',
            "@reset" => 'button[type="reset"]',
            "@separator" => 'div[data-orientation][role="none"]',
        ];
    }
}
