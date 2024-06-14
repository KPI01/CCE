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
            '@nombres' => 'input[name="nombres"]',
            '@nombres-err' => 'input[name="nombres"] + p',
            '@apellidos' => 'input[name="apellidos"]',
            '@apellidos-err' => 'input[name="apellidos"] + p',
            '@tipo_id_nac' => 'select[name="tipo_id_nac"]',
            '@id_nac' => 'input[name="id_nac"]',
            '@id_nac-err' => 'input[name="id_nac"] + p',
            '@email' => 'input[name="email"]',
            '@email-err' => 'input[name="email"] + p',
            '@tel' => 'input[name="tel"]',
            '@perfil' => '#perfil + select',
            '@observaciones' => 'textarea[name="observaciones"]',
            '@ropo-checkbox-btn' => 'button#ropo',
            '@ropo-checkbox' => 'button#ropo + input[type="checkbox"]',
            '@ropo-form' => '#ropo-form',
            '@ropo.tipo' => '#ropo-form #ropo-tipo + select',
            '@ropo.caducidad-input' => '#ropo-form #ropo-caducidad_input',
            '@ropo.caducidad-trigger' => '#ropo-form #ropo-caducidad_trigger',
            '@ropo.caducidad-calendar' => '#ropo-caducidad_calendar',
            '@ropo.nro' => 'input[name="ropo.nro"]',
            '@ropo.tipo_aplicador' => '#ropo-form #ropo-tipo_aplicador + select',
            '@submit' => 'button[type="submit"]',
            '@reset' => 'button[type="reset"]',
        ];
    }
}
