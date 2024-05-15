<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * Test simple de acceso al formulario.
     */
    public function testAccesoFormulario(): void
    {
        $admin = User::where('name', 'Informatica')->first();

        $res = $this->actingAs($admin)
            ->withSession(['banned' => false])
            ->get(route('form.login'));

        $res->assertStatus(200);
    }

    /**
     * Test de inicio de sesión con el usuario de informática.
     */
    public function testLogin(): void
    {
        $admin = User::where('name', 'Informatica')->first();

        $res = $this->actingAs($admin)
            ->post(route('login.usuario'), [
                'email' => 'informatica@fruveco.com',
                'password' => 'Fruveco@2024',
            ]);

        $res->assertStatus(302)
            ->assertRedirectContains(route('dashboard.usuario'))
            ->assertCookie('XSRF-TOKEN')
            ->assertCookie('cce_session')
            ->assertSessionDoesntHaveErrors();
    }

    /**
     * Test de acceso al formulario cuando hay una sesión activa
     */
    public function testAccesoConSesionActiva ()
    {
        $admin = User::where('name', 'Informatica')->first();

        $res = $this->actingAs($admin);
    }
}
