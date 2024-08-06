<?php

namespace Tests\Feature;

use App\Mail\Ejemplo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CorreoTest extends TestCase
{
    /**
     * Test simple de envío de correo.
     */
    public function testEnvioCorreo(): void
    {
        Mail::fake();

        Mail::to("betiga1211@bsomek.com")->send(new Ejemplo("Hola Mundo!"));

        Mail::assertSent(Ejemplo::class);
    }
}
