<?php

namespace Tests\Browser\Pages\Recursos;

use Illuminate\Http\Request;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class Form extends Page
{
    private array $validAcc = ["show", "edit", "create"];
    private string $rcs;
    private string $acc;
    private string|null $id;

    public function __construct(
        string $recurso,
        string $accion,
        string $id = null
    ) {
        if (!in_array($accion, $this->validAcc)) {
            echo "Acción no válida" . PHP_EOL;
            $arr_str = implode(", ", $this->validAcc);
            report("La acción debe ser alguna de las siguientes: $arr_str");
        }

        $this->rcs = $recurso;
        $this->acc = $accion;
        $this->id = $id;
    }
    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        $rt = null;
        $accion = implode(".", [$this->rcs, $this->acc]);
        if (in_array($this->acc, ["edit", "show"]) && isset($this->id)) {
            $rt = Request::create(uri: route($accion, $this->id));
        } else {
            $rt = Request::create(uri: route($accion));
        }

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
            "@back-btn" => "button#back-btn",
        ];
    }
}
