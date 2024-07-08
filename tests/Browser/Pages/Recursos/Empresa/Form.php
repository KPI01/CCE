<?php

namespace Tests\Browser\Pages\Recursos\Empresa;

use App\Models\Empresa;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class Form extends Page
{
    protected string $rcs;
    protected string $acc;
    protected Empresa $inst;

    public function __construct(string $accion, Empresa $instancia = null)
    {
        if (!in_array($accion, ["index", "show", "edit", "create"])) {
            throw new InvalidArgumentException("Acción invalida");
        }

        $this->rcs = "empresas";
        $this->acc = $accion;
        !is_null($instancia) && ($this->inst = $instancia);
    }

    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        if (in_array($this->acc, ["show", "edit"])) {
            $url = Request::create(
                route("$this->rcs.$this->acc", $this->inst->id)
            );
            return "/" . $url->path();
        }

        $url = Request::create(route("$this->rcs.$this->acc"));
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
