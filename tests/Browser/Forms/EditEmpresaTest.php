<?php

namespace Tests\Browser\Edit;

use App\Models\Empresa;
use Carbon\Carbon;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Recursos\Form;
use Illuminate\Support\Arr;
use Tests\RecursoDuskTestCase;

class EditEmpresaTest extends RecursoDuskTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->hasDeleteBtn = true;
        $this->class = Empresa::class;
        $this->recurso = "empresa";
        $this->row = Empresa::factory(1, [
            "perfil" => "Productor",
        ])
            ->withRopo()
            ->create()
            ->first();
        $this->PARAMS = ["empresa", "edit", $this->row->id];
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
                ->assertPresent("@label-nombre")
                ->assertPresent("@label-nif")
                ->assertPresent("@label-email")
                ->assertPresent("@label-perfil")
                ->assertPresent("@label-tel")
                ->assertPresent("@label-direccion")
                ->assertPresent("@label-codigo")
                ->assertPresent("@label-observaciones");

            $browser
                ->assertPresent("@input-nombre")
                ->assertPresent("@input-nif")
                ->assertPresent("@input-email")
                ->assertPresent("@trigger-perfil")
                ->assertPresentByName("select", "perfil")
                ->assertPresent("@input-tel")
                ->assertPresent("@txt-direccion")
                ->assertPresent("@input-codigo")
                ->assertPresent("@txt-observaciones");
        });
    }

    public function testAccesibilidadRopo(): void
    {
        parent::testAccesibilidad();
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser->assertPresent("@h3-ropo");

            $browser
                ->assertPresent("@label-ropo_capacitacion")
                ->assertPresent("@input-ropo_nro")
                ->assertPresent("@label-ropo_caducidad");

            $browser
                ->assertPresent("@trigger-ropo_capacitacion")
                ->assertPresentByName("select", '"ropo.capacitacion"')
                ->assertPresent("@input-ropo_nro")
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
                ->assertVisible("@label-nombre")
                ->assertVisible("@label-nif")
                ->assertVisible("@label-email")
                ->assertVisible("@label-perfil")
                ->assertVisible("@label-tel")
                ->assertVisible("@label-direccion")
                ->assertVisible("@label-codigo")
                ->assertVisible("@label-observaciones");

            $browser
                ->assertVisible("@input-nombre")
                ->assertVisible("@input-nif")
                ->assertVisible("@input-email")
                ->assertVisible("@trigger-perfil")
                ->assertVisibleByName("select", "perfil")
                ->assertVisible("@input-tel")
                ->assertVisible("@txt-direccion")
                ->assertVisible("@input-codigo")
                ->assertVisible("@txt-observaciones");
        });
    }

    public function testVisibilidadRopo(): void
    {
        parent::testVisibilidad();
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser->assertVisible("@h3-ropo");

            $browser
                ->assertVisible("@label-ropo_capacitacion")
                ->assertVisible("@input-ropo_nro")
                ->assertVisible("@label-ropo_caducidad");

            $browser
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
                ->assertEnabled("@input-nombre")
                ->assertEnabled("@input-nif")
                ->assertEnabled("@input-email")
                ->assertEnabled("@trigger-perfil")
                ->assertEnabledByName("select", "perfil")
                ->assertEnabled("@input-tel")
                ->assertEnabled("@txt-direccion")
                ->assertEnabled("@input-codigo")
                ->assertEnabled("@txt-observaciones");
        });
    }

    public function testCamposHabilitadosRopo(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
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
                ->assertInputValue("@input-nombre", $this->row->nombre)
                ->assertInputValue("@input-nif", $this->row->nif)
                ->assertInputValue("@input-email", $this->row->email)
                ->assertInputValue("@input-tel", $this->row->tel)
                ->assertInputValue("@input-codigo", $this->row->codigo)
                ->assertSeeIn("@trigger-perfil", $this->row->perfil)
                ->assertInputValue("@txt-direccion", $this->row->direccion)
                ->assertInputValue(
                    "@txt-observaciones",
                    $this->row->observaciones
                );

            $browser
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

            for ($i = 0; $i < strlen($this->row->nombre); $i++) {
                $browser->keys("@input-nombre", "{backspace}");
            }
            $browser->assertInputValue("@input-nombre", "");

            for ($i = 0; $i < strlen($this->row->nif); $i++) {
                $browser->keys("@input-nif", "{backspace}");
            }
            $browser->assertInputValue("@input-nif", "");

            for ($i = 0; $i < strlen($this->row->email); $i++) {
                $browser->keys("@input-email", "{backspace}");
            }
            $browser->assertInputValue("@input-email", "");

            $browser
                ->press("@submit")
                ->assertSeeIn("@msg-nombre", "El nombre es requerido")
                ->assertSeeIn("@msg-nif", "El NIF es requerido")
                ->assertSeeIn("@msg-email", "El correo es requerido");
        });
    }

    public function testCampoVaciado(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            for ($i = 0; $i < strlen($this->row->tel); $i++) {
                $browser->keys("@input-tel", "{backspace}");
            }
            $browser->assertInputValue("@input-tel", "");

            for ($i = 0; $i < strlen($this->row->codigo); $i++) {
                $browser->keys("@input-codigo", "{backspace}");
            }
            $browser->assertInputValue("@input-codigo", "");

            for ($i = 0; $i < strlen($this->row->direccion); $i++) {
                $browser->keys("@txt-direccion", "{backspace}");
            }
            $browser->assertInputValue("@txt-direccion", "");

            for ($i = 0; $i < strlen($this->row->observaciones); $i++) {
                $browser->keys("@txt-observaciones", "{backspace}");
            }
            $browser->assertInputValue("@txt-observaciones", "");

            $browser
                ->press("@submit")
                ->pause(1000)
                ->assertRouteIs("empresa.show", ["empresa" => $this->row->id]);
        });

        $attr = Arr::only($this->row->getAttributes(), [
            "id",
            "nombre",
            "matricula",
            "tipo_id",
        ]);
        $this->assertDatabaseHas(Empresa::class, $attr);

        $attr = Arr::except($this->row->getAttributes(), [
            "id",
            "created_at",
            "updated_at",
            "nombre",
            "nif",
            "email",
        ]);
        $this->assertDatabaseMissing(Empresa::class, $attr);
    }
sólo debe contener:
    public function testEnvioInvalido(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->type("@input-nombre", "aslkd87%$&&")
                ->type("@input-nif", "123546")
                ->type("@input-email", "correo@")
                ->type("@input-tel", "13246598")
                ->type("@input-codigo", "abd&%")
                ->press("@submit");

            $browser
                ->assertSeeIn(
                    "@msg-nombre",
                    "El nombre sólo debe contener: letras, números, (), ., -, ·, &."
                )
                ->assertSeeIn("@msg-nif", "El NIF debe ser válido.")
                ->assertSeeIn("@msg-email", "El correo debe ser válido.")
                ->assertSeeIn("@msg-tel", "El teléfono debe ser válido.")
                ->assertSeeIn(
                    "@msg-codigo",
                    "El código sólo debe contener: números."
                );
        });
    }

    public function testEnvioInvalidoRopo(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser->type("@input-ropo_nro", "53526%$")->press("@submit");

            $browser->assertSeeIn(
                "@msg-ropo_nro",
                "La identificación ROPO debe ser válida."
            );
        });
    }

    public function testEnvioValido(): void
    {
        $data = Empresa::factory(1, ["perfil" => "Productor"])
            ->make()
            ->first();

        $this->browse(function (Browser $browser) use ($data) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->type("@input-nombre", $data->nombre)
                ->type("@input-nif", $data->nif)
                ->type("@input-email", $data->email)
                ->type("@input-tel", $data->tel)
                ->type("@txt-direccion", $data->direccion)
                ->type("@input-codigo", $data->codigo)
                ->type("@txt-observaciones", $data->observaciones)
                ->press("@submit");

            $browser
                ->pause(1000)
                ->assertRouteIs("empresa.show", ["empresa" => $this->row->id]);
        });

        $this->assertDatabaseHas(Empresa::class, ["id" => $this->row->id]);
        $this->assertDatabaseMissing(
            Empresa::class,
            Arr::except($this->row->getAttributes(), [
                "id",
                "created_at",
                "updated_at",
            ])
        );
        $this->assertDatabaseHas(
            Empresa::class,
            Arr::except($data->getAttributes(), [
                "id",
                "created_at",
                "updated_at",
            ])
        );
    }

    // public function testEnvioValidoRopo(): void
    // {
    // }
}
