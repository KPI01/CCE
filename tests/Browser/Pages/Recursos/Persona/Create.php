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
            '@nombres-message' => 'form#create-persona-form #nombres-message',
            '@apellidos' => 'input[name="apellidos"]',
            '@apellidos-message' => 'form#create-persona-form #apellidos-message',
            '@tipo_id_nac' => 'select[name="tipo_id_nac"]',
            '@id_nac' => 'input[name="id_nac"]',
            '@id_nac-message' => 'form#create-persona-form #id_nac-message',
            '@email' => 'input[name="email"]',
            '@email-message' => 'form#create-persona-form #email-message',
            '@tel' => 'input[name="tel"]',
            '@tel-message' => 'form#create-persona-form #tel-message',
            '@perfil' => '#perfil + select',
            '@observaciones' => 'textarea[name="observaciones"]',
            '@ropo-checkbox-btn' => 'button#ropo',
            '@ropo-checkbox' => 'button#ropo + input[type="checkbox"]',
            '@ropo-form' => '#ropo-form',
            '@ropo.tipo' => '#ropo-form #ropo-tipo + select',
            '@ropo.tipo-message' => '#ropo-form #ropo_tipo-message',
            '@ropo.caducidad-trigger' => '#ropo-form #ropo_caducidad-trigger',
            '@ropo.caducidad-value' => '#ropo-form #ropo_caducidad-value',
            '@ropo.caducidad-input' => '#ropo-form #ropo_caducidad-input',
            '@ropo.caducidad-calendar' => '#ropo_caducidad-calendar',
            '@ropo.caducidad-message' => '#ropo-form #ropo.caducidad-message',
            '@ropo.nro' => 'input[name="ropo.nro"]',
            '@ropo.nro-message' => '#ropo-form #ropo_nro-message',
            '@ropo.tipo_aplicador' => '#ropo-form select[name="ropo.tipo_aplicador"]',
            '@ropo.tipo_aplicador-message' => '#ropo-form #ropo.tipo_aplicador-message',
            '@submit' => 'button[type="submit"]',
            '@reset' => 'button[type="reset"]',
        ];
    }
}
