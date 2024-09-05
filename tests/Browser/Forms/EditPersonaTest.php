<?php

namespace Tests\Browser\Edit;

use App\Models\Persona;
use Carbon\Carbon;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Recursos\Form;
use Tests\RecursoDuskTestCase;
use Illuminate\Support\Arr;

class EditPersonaTest extends RecursoDuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->hasDeleteBtn = true;
        $this->class = Persona::class;
        $this->recurso = "persona";
        $this->row = Persona::factory(1, [
            "perfil" => "Productor",
        ])
            ->withRopo()
            ->create()
            ->first();
        $this->PARAMS = ["persona", "edit", $this->row->id];
    }

    public function testAccesibilidad(): void
    {
        parent::testAccesibilidad();
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->assertPresent("@breadcrumb")
                ->assertPresent("@title")
                ->assertPresent("@form-edit-{$this->PARAMS[2]}")
                ->assertPresent("@badge-createdAt")
                ->assertPresent("@badge-updatedAt");

            $browser
                ->assertPresent("@label-nombres")
                ->assertPresent("@label-apellidos")
                ->assertPresent("@label-id_nac")
                ->assertPresent("@label-email")
                ->assertPresent("@label-perfil")
                ->assertPresent("@label-tel")
                ->assertPresent("@label-observaciones")
                ->assertPresent("@label-ropo_capacitacion")
                ->assertPresent("@label-ropo_nro")
                ->assertPresent("@label-ropo_caducidad");

            $browser
                ->assertPresent("@input-nombres")
                ->assertPresent("@input-apellidos")
                ->assertPresent("@trigger-tipo_id_nac")
                ->assertPresentByName("select", "tipo_id_nac")
                ->assertPresent("@input-id_nac")
                ->assertPresent("@input-email")
                ->assertPresent("@trigger-perfil")
                ->assertPresentByName("select", "perfil")
                ->assertPresent("@input-tel")
                ->assertPresent("@label-observaciones")
                ->assertPresent("@trigger-ropo_capacitacion")
                ->assertPresentByName("select", '"ropo.capacitacion"')
                ->assertPresent("@label-ropo_nro")
                ->assertPresent("@trigger-ropo_caducidad");
        });
    }

    public function testVisibilidad(): void
    {
        parent::testVisibilidad();
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->assertVisible("@breadcrumb")
                ->assertVisible("@title")
                ->assertVisible("@form-edit-{$this->PARAMS[2]}")
                ->assertVisible("@badge-createdAt")
                ->assertVisible("@badge-updatedAt");

            $browser
                ->assertVisible("@label-nombres")
                ->assertVisible("@label-apellidos")
                ->assertVisible("@label-id_nac")
                ->assertVisible("@label-email")
                ->assertVisible("@label-perfil")
                ->assertVisible("@label-tel")
                ->assertVisible("@label-observaciones")
                ->assertVisible("@label-ropo_capacitacion")
                ->assertVisible("@label-ropo_nro")
                ->assertVisible("@label-ropo_caducidad");

            $browser
                ->assertVisible("@input-nombres")
                ->assertVisible("@input-apellidos")
                ->assertVisible("@trigger-tipo_id_nac")
                ->assertVisibleByName("select", "tipo_id_nac")
                ->assertVisible("@input-id_nac")
                ->assertVisible("@input-email")
                ->assertVisible("@trigger-perfil")
                ->assertVisibleByName("select", "perfil")
                ->assertVisible("@input-tel")
                ->assertVisible("@label-observaciones")
                ->assertVisible("@trigger-ropo_capacitacion")
                ->assertVisibleByName("select", '"ropo.capacitacion"')
                ->assertVisible("@input-ropo_nro")
                ->assertVisible("@trigger-ropo_caducidad");
        });
    }

    public function testCamposHabilitados(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->assertEnabled("@input-nombres")
                ->assertEnabled("@input-apellidos")
                ->assertEnabled("@trigger-tipo_id_nac")
                ->assertEnabled("@input-id_nac")
                ->assertEnabled("@input-email")
                ->assertEnabled("@trigger-perfil")
                ->assertEnabledByName("select", "perfil")
                ->assertEnabled("@input-tel")
                ->assertEnabled("@txt-observaciones")
                ->assertEnabled("@trigger-ropo_capacitacion")
                ->assertEnabledByName("select", '"ropo.capacitacion"')
                ->assertEnabled("@input-ropo_nro")
                ->assertEnabled("@trigger-ropo_caducidad");
        });
    }

    public function testValidacionInformacion(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->assertInputValue("@input-nombres", $this->row->nombres)
                ->assertInputValue("@input-apellidos", $this->row->apellidos)
                ->assertSeeIn("@trigger-tipo_id_nac", $this->row->tipo_id_nac)
                ->assertInputValue("@input-id_nac", $this->row->id_nac)
                ->assertInputValue("@input-email", $this->row->email)
                ->assertSeeIn("@trigger-perfil", $this->row->perfil)
                ->assertInputValue("@input-tel", $this->row->tel)
                ->assertInputValue(
                    "@txt-observaciones",
                    $this->row->observaciones
                )
                ->assertSeeIn(
                    "@trigger-ropo_capacitacion",
                    $this->row->ropo["capacitacion"]
                )
                ->assertInputValue("@input-ropo_nro", $this->row->ropo["nro"])
                ->assertSeeIn(
                    "@trigger-ropo_caducidad",
                    Carbon::parse($this->row->ropo["caducidad"])->format(
                        "d/m/Y"
                    )
                );
        });
    }

    public function testEnvioRequeridosVacios(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            for ($i = 0; $i < strlen($this->row->nombres); $i++) {
                $browser->keys("@input-nombres", "{backspace}");
            }
            $browser->assertInputValue("@input-nombres", "");

            for ($i = 0; $i < strlen($this->row->apellidos); $i++) {
                $browser->keys("@input-apellidos", "{backspace}");
            }
            $browser->assertInputValue("@input-apellidos", "");

            for ($i = 0; $i < strlen($this->row->id_nac); $i++) {
                $browser->keys("@input-id_nac", "{backspace}");
            }
            $browser->assertInputValue("@input-id_nac", "");

            for ($i = 0; $i < strlen($this->row->email); $i++) {
                $browser->keys("@input-email", "{backspace}");
            }
            $browser->assertInputValue("@input-email", "");

            $browser
                ->press("@submit")
                ->assertSeeIn("@msg-nombres", "El nombre es requerido")
                ->assertSeeIn("@msg-apellidos", "El apellido es requerido")
                ->assertSeeIn("@msg-id_nac", "La identificación es requerida")
                ->assertSeeIn("@msg-email", "El correo es requerido");
        });
    }

    public function testCamposVaciados(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            for ($i = 0; $i < strlen($this->row->tel); $i++) {
                $browser->keys("@input-tel", "{backspace}");
            }
            $browser->assertInputValue("@input-tel", "");

            for ($i = 0; $i < strlen($this->row->observaciones); $i++) {
                $browser->keys("@txt-observaciones", "{backspace}");
            }
            $browser->assertInputValue("@txt-observaciones", "");

            $browser
                ->press("@submit")
                ->pause(1000)
                ->assertRouteIs("persona.show", ["persona" => $this->row->id]);
        });

        $this->assertDatabaseHas(
            Persona::class,
            Arr::only($this->row->getAttributes(), [
                "id",
                "nombres",
                "apellidos",
                "tipo_id_nac",
                "id_nac",
                "email",
            ])
        );
        $this->assertDatabaseMissing(
            Persona::class,
            Arr::only($this->row->getAttributes(), ["tel", "observaciones"])
        );
    }

    public function testEnvioInvalido(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->type("@input-nombres", "ldskj/&/")
                ->type("@input-apellidos", "aslkdj/(%")
                ->type("@input-id_nac", "abc872")
                ->type("@input-email", "persona@")
                ->type("@input-tel", "9831896")
                ->type("@input-ropo_nro", "53526%$")
                ->press("@submit");

            $browser
                ->assertSeeIn(
                    "@msg-nombres",
                    "El nombre sólo debe contener: letras"
                )
                ->assertSeeIn(
                    "@msg-apellidos",
                    "El apellido sólo debe contener: letras"
                )
                ->assertSeeIn(
                    "@msg-id_nac",
                    "La identificación debe ser válida"
                )
                ->assertSeeIn("@msg-email", "El correo debe ser válido")
                ->assertSeeIn("@msg-tel", "El teléfono debe ser válido")
                ->assertSeeIn(
                    "@msg-ropo_nro",
                    "La identificación ROPO debe ser válida."
                );

            $browser->assertRouteIs("persona.edit", [
                "persona" => $this->row->id,
            ]);
        });
    }

    public function testEnvioValido(): void
    {
        $data = Persona::factory(1, [
            "tipo_id_nac" => "DNI",
            "id_nac" => fake()->unique()->dni(),
            "perfil" => "Productor",
        ])
            ->withRopo()
            ->make()
            ->first();

        $this->browse(function (Browser $browser) use ($data) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->type("@input-nombres", $data->nombres)
                ->type("@input-apellidos", $data->apellidos)
                ->type("@input-id_nac", $data->id_nac)
                ->type("@input-email", $data->email)
                ->type("@input-tel", $data->tel)
                ->type("@txt-observaciones", $data->observaciones)
                ->type("@input-ropo_nro", $data->ropo["nro"])
                ->press("@submit");

            $browser
                ->pause(1000)
                ->assertRouteIs("persona.show", ["persona" => $this->row->id]);
        });

        $this->assertDatabaseHas(Persona::class, ["id" => $this->row->id]);
        $this->assertDatabaseMissing(
            Persona::class,
            Arr::except($this->row->getAttributes(), [
                "id",
                "created_at",
                "updated_at",
            ])
        );
        $this->assertDatabaseHas(
            Persona::class,
            Arr::except($data->getAttributes(), [
                "id",
                "created_at",
                "updated_at",
            ])
        );
    }
}
