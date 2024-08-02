<?php

namespace Tests\Browser\Edit;

use App\Models\Empresa;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Keyboard;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\Recursos\Form;
use Tests\DuskTestCase;

class EditEmpresaTest extends DuskTestCase
{
    private Empresa $instFull;
    private Empresa $instParcial;

    public function setUp(): void
    {
        parent::setUp();
        $this->instParcial = Empresa::factory(1)
            ->state([
                "tel" => "",
                "codigo" => "",
                "direccion" => "",
                "observaciones" => "",
            ])
            ->create()
            ->first();
        $this->instFull = Empresa::factory(1)->withRopo()->create()->first();
    }

    public function testAcceso(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(
                new Form(
                    recurso: "empresas",
                    accion: "edit",
                    id: $this->instFull->id
                )
            );
        });
    }

    public function testAccesibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(
                new Form(
                    recurso: "empresas",
                    accion: "edit",
                    id: $this->instFull->id
                )
            );

            $browser->within(new Navbar(), function (Browser $browser) {
                $browser
                    ->assertPresent("@navbar")
                    ->assertPresent("@acc-home")
                    ->assertPresent("@acc-recursos")
                    ->assertPresent("@acc-config");
            });

            $browser
                ->assertPresent("@h3-generales")
                ->storeSource("empresas_accesibilidad")
                ->assertPresent("@form-edit-{$this->instFull->id}")
                ->assertPresent("@label-nombre")
                ->assertPresent("@input-nombre")
                ->assertPresent("@label-nif")
                ->assertPresent("@input-nif")
                ->assertPresent("@label-email")
                ->assertPresent("@input-email")
                ->assertPresent("@label-tel")
                ->assertPresent("@input-tel")
                ->assertPresent("@label-direccion")
                ->assertPresent("@txt-direccion")
                ->assertPresent("@label-perfil")
                ->assertPresentByName("select", "perfil")
                ->assertPresent("@label-codigo")
                ->assertPresent("@input-codigo")
                ->assertPresent("@label-observaciones")
                ->assertPresent("@txt-observaciones");

            $browser
                ->assertPresent("@h3-ropo")
                ->assertPresent("@label-ropo_capacitacion")
                ->assertPresent("@trigger-ropo_capacitacion")
                ->assertPresentByName("select", "ropo.capacitacion")
                ->assertPresent("@label-ropo_nro")
                ->assertPresent("@input-ropo_nro")
                ->assertPresent("@label-ropo_caducidad")
                ->assertPresent("@trigger-ropo_caducidad")
                ->assertPresent("@input-ropo_caducidad");

            $browser->assertPresent("@submit");
        });
    }

    public function testVisibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(
                new Form(
                    recurso: "empresas",
                    accion: "edit",
                    id: $this->instFull->id
                )
            );

            $browser->within(new Navbar(), function (Browser $browser) {
                $browser
                    ->assertVisible("@navbar")
                    ->assertVisible("@acc-home")
                    ->assertVisible("@acc-recursos")
                    ->assertVisible("@acc-config");
            });

            $browser
                ->assertVisible("@h3-generales")
                ->assertVisible("@form-edit-{$this->instFull->id}")
                ->assertVisible("@label-nombre")
                ->assertVisible("@input-nombre")
                ->assertVisible("@label-nif")
                ->assertVisible("@input-nif")
                ->assertVisible("@label-email")
                ->assertVisible("@input-email")
                ->assertVisible("@label-tel")
                ->assertVisible("@input-tel")
                ->assertVisible("@label-direccion")
                ->assertVisible("@txt-direccion")
                ->assertVisible("@label-perfil")
                ->assertVisibleByName("select", "perfil")
                ->assertVisible("@label-codigo")
                ->assertVisible("@input-codigo")
                ->assertVisible("@label-observaciones")
                ->assertVisible("@txt-observaciones");

            $browser
                ->assertVisible("@h3-ropo")
                ->assertVisible("@label-ropo_capacitacion")
                ->assertVisible("@trigger-ropo_capacitacion")
                ->assertVisibleByName("select", "ropo.capacitacion")
                ->assertVisible("@label-ropo_nro")
                ->assertVisible("@input-ropo_nro")
                ->assertVisible("@label-ropo_caducidad")
                ->assertVisible("@trigger-ropo_caducidad");

            $browser->assertVisible("@submit");
        });
    }

    public function testCamposHabilitados(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(
                new Form(
                    recurso: "empresas",
                    accion: "edit",
                    id: $this->instFull->id
                )
            );

            $browser
                ->assertEnabled("@input-nombre")
                ->assertEnabled("@input-nif")
                ->assertEnabled("@input-email")
                ->assertEnabled("@input-tel")
                ->assertEnabled("@txt-direccion")
                ->assertEnabled("@trigger-perfil")
                ->assertEnabledByName("select", "perfil")
                ->assertEnabled("@input-codigo")
                ->assertEnabled("@txt-observaciones");

            $browser
                ->assertEnabled("@trigger-ropo_capacitacion")
                ->assertEnabledByName("select", "ropo.capacitacion")
                ->assertEnabled("@input-ropo_nro")
                ->assertEnabled("@trigger-ropo_caducidad")
                ->assertEnabled("@input-ropo_caducidad");

            $browser->assertEnabled("@submit");
        });
    }

    public function testValorCampos(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(
                new Form(
                    recurso: "empresas",
                    accion: "edit",
                    id: $this->instFull->id
                )
            );

            $browser
                ->assertInputValue("@input-nombre", $this->instFull->nombre)
                ->assertInputValue("@input-nif", $this->instFull->nif)
                ->assertInputValue("@input-email", $this->instFull->email)
                ->assertInputValue("@input-tel", $this->instFull->tel)
                ->assertInputValue("@txt-direccion", $this->instFull->direccion)
                ->assertSelectedByName("perfil", $this->instFull->perfil)
                ->assertInputValue("@input-codigo", $this->instFull->codigo)
                ->assertInputValue(
                    "@txt-observaciones",
                    $this->instFull->observaciones
                );

            $browser
                ->assertSelectedByName(
                    "ropo.capacitacion",
                    $this->instFull->ropo["capacitacion"]
                )
                ->assertInputValue(
                    "@input-ropo_nro",
                    $this->instFull->ropo["nro"]
                )
                ->assertInputValue(
                    "@input-ropo_caducidad",
                    $this->instFull->ropo["caducidad"]
                );
        });
    }

    public function testEdicionCampos(): void
    {
        $ropo_rgx1 = '^[0-9]{7,12}[S]?[ASTU]$';
        $ropo_rgx2 = '^[0-9]{1,3}/[0-9]{1,3}$';

        $dataToUpdate = [
            "nombre" => fake()->company(),
            "nif" => fake()->vat(),
            "email" => fake()->companyEmail(),
            "tel" => fake()->tollFreeNumber(),
            "direccion" => fake()->address(),
            "perfil" => fake()->randomElement(Empresa::PERFILES),
            "codigo" => fake()->numerify("######"),
            "observaciones" => fake()->text(),
            "ropo" => [
                "capacitacion" => fake()->randomElement(
                    Empresa::CAPACITACIONES_ROPO
                ),
                "nro" => fake()->boolean()
                    ? fake()->regexify($ropo_rgx1)
                    : fake()->regexify($ropo_rgx2),
                "caducidad" => fake()->dateTimeBetween("now", "+5 years"),
            ],
        ];

        $this->browse(function (Browser $browser) use ($dataToUpdate) {
            $browser->visit(
                new Form(
                    recurso: "empresas",
                    accion: "edit",
                    id: $this->instFull->id
                )
            );

            $browser
                ->type("@input-nombre", $dataToUpdate["nombre"])
                ->assertInputValue("@input-nombre", $dataToUpdate["nombre"])
                ->type("@input-nif", $dataToUpdate["nif"])
                ->assertInputValue("@input-nif", $dataToUpdate["nif"])
                ->type("@input-email", $dataToUpdate["email"])
                ->assertInputValue("@input-email", $dataToUpdate["email"])
                ->type("@input-tel", $dataToUpdate["tel"])
                ->assertInputValue("@input-tel", $dataToUpdate["tel"])
                ->type("@txt-direccion", $dataToUpdate["direccion"])
                ->assertInputValue("@txt-direccion", $dataToUpdate["direccion"])
                ->selectByName("perfil", $dataToUpdate["perfil"])
                ->assertSelectedByName("perfil", $dataToUpdate["perfil"])
                ->type("@input-codigo", $dataToUpdate["codigo"])
                ->assertInputValue("@input-codigo", $dataToUpdate["codigo"])
                ->type("@txt-observaciones", $dataToUpdate["observaciones"])
                ->assertInputValue(
                    "@txt-observaciones",
                    $dataToUpdate["observaciones"]
                )
                ->selectByName(
                    "ropo.capacitacion",
                    $dataToUpdate["ropo"]["capacitacion"]
                )
                ->assertSelectedByName(
                    "ropo.capacitacion",
                    $dataToUpdate["ropo"]["capacitacion"]
                )
                ->type("@input-ropo_nro", $dataToUpdate["ropo"]["nro"])
                ->assertInputValue(
                    "@input-ropo_nro",
                    $dataToUpdate["ropo"]["nro"]
                    /** Implementar forma de seleccionar una fecha con el date picker */
                );
        });
    }

    public function testEnvioRequeridoInvalido(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(
                new Form(
                    recurso: "empresas",
                    accion: "edit",
                    id: $this->instFull->id
                )
            );

            $browser
                ->assertValueIsNot("@input-nombre", "")
                ->assertValueIsNot("@input-nif", "")
                ->assertValueIsNot("@input-email", "");

            $browser
                ->doubleClick("@input-nombre")
                ->withKeyboard(function (Keyboard $keyboard) {
                    $nombreLength = strlen($this->instFull->nombre);
                    for ($i = 0; $i < $nombreLength; $i++) {
                        $keyboard->press(parent::KEYS["backspace"]);
                    }
                })
                ->assertInputValue("@input-nombre", "")
                ->press("@submit")
                ->assertPresent("@msg-nombre")
                ->assertSeeIn("@msg-nombre", "Este campo es requerido")
                ->type("@input-nombre", $this->instFull->nombre);

            $browser
                ->doubleClick("@input-nif")
                ->withKeyboard(function (Keyboard $keyboard) {
                    $nifLength = strlen($this->instFull->nif);
                    for ($i = 0; $i < $nifLength; $i++) {
                        $keyboard->press(parent::KEYS["backspace"]);
                    }
                })
                ->assertInputValue("@input-nif", "")
                ->press("@submit")
                ->assertPresent("@msg-nif")
                ->assertSeeIn("@msg-nif", "Este campo es requerido")
                ->type("@input-nif", $this->instFull->nif);

            $browser
                ->doubleClick("@input-email")
                ->withKeyboard(function (Keyboard $keyboard) {
                    $emailLength = strlen($this->instFull->email);
                    for ($i = 0; $i < $emailLength; $i++) {
                        $keyboard->press(parent::KEYS["backspace"]);
                    }
                })
                ->assertInputValue("@input-email", "")
                ->press("@submit")
                ->assertPresent("@msg-email")
                ->assertSeeIn("@msg-email", "Este campo es requerido")
                ->type("@input-email", $this->instFull->email);
        });
    }

    public function testEnvioInvalido(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(
                new Form(
                    recurso: "empresas",
                    accion: "edit",
                    id: $this->instFull->id
                )
            );

            $browser
                ->type("@input-nombre", "abc$%/")
                ->assertInputValue("@input-nombre", "abc$%/")
                ->press("@submit")
                ->assertPresent("@msg-nombre")
                ->assertSeeIn(
                    "@msg-nombre",
                    "El nombre solo puede contener letras, números, o (, . - · &)."
                );
            $browser
                ->type("@input-nif", "bmn764")
                ->assertInputValue("@input-nif", "bmn764")
                ->press("@submit")
                ->assertPresent("@msg-nif")
                ->assertSeeIn("@msg-nif", "El NIF debe ser válido.");
            $browser
                ->type("@input-email", "abcdef.com")
                ->assertInputValue("@input-email", "abcdef.com")
                ->press("@submit")
                ->assertPresent("@msg-email")
                ->assertSeeIn("@msg-email", "El correo debe ser válido");
            $browser
                ->type("@input-tel", "1234")
                ->assertInputValue("@input-tel", "1234")
                ->press("@submit")
                ->assertPresent("@msg-tel")
                ->assertSeeIn(
                    "@msg-tel",
                    "El número de teléfono debe ser válido"
                );
            $browser
                ->type("@input-codigo", "abc4321")
                ->assertInputValue("@input-codigo", "abc4321")
                ->press("@submit")
                ->assertPresent("@msg-codigo")
                ->assertInputValue(
                    "@msg-codigo",
                    "Este campo debe ser válido."
                );
            $dir = fake()->text(350);
            while (strlen($dir) <= 300) {
                $dir .= fake()->sentence(25);
            }
            $browser
                ->type("@txt-direccion", $dir)
                ->assertInputValue("@txt-direccion", $dir)
                ->press("@submit")
                ->assertPresent("@msg-direccion")
                ->assertSeeIn(
                    "@msg-direccion",
                    "La dirección debe tener como máximo 300 caracteres."
                );
            $obsv = fake()->text(1000);
            while (strlen($obsv) <= 1000) {
                $obsv .= fake()->sentence(50);
            }
            $browser
                ->type("@txt-observaciones", $obsv)
                ->assertInputValue("@txt-observaciones", $obsv)
                ->press("@submit")
                ->assertPresent("@msg-observaciones")
                ->assertSeeIn(
                    "@msg-observaciones",
                    "Las observaciones deben tener como máximo 1000 caracteres."
                );

            $browser
                ->visit(
                    new Form(
                        recurso: "empresas",
                        accion: "edit",
                        id: $this->instFull->id
                    )
                )
                ->type("@input-ropo_nro", "12354")
                ->assertInputValue("@input-ropo_nro", "12354")
                ->press("@submit")
                ->assertPresent("@msg-ropo_nro")
                ->assertSeeIn(
                    "@msg-ropo_nro",
                    "La identificación ROPO debe estar en el formato adecuado"
                );
        });
    }

    public function testCorreccionInvalida(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(
                new Form(
                    recurso: "empresas",
                    accion: "edit",
                    id: $this->instFull->id
                )
            );

            $browser
                ->type("@input-nombre", "abct%%$")
                ->assertInputValue("@input-nombre", "abct%%$")
                ->press("@submit")
                ->assertPresent("@msg-nombre")
                ->assertSeeIn(
                    "@msg-nombre",
                    "El nombre solo puede contener letras, números, o (, . - · &)."
                )
                ->type("@input-nombre", "dh")
                ->assertInputValue("@input-nombre", "dh")
                ->assertSeeIn(
                    "@msg-nombre",
                    "El nombre debe tener al menos 3 caracteres."
                );
            $browser
                ->type("@input-nif", "A123")
                ->assertInputValue("@input-nif", "A123")
                ->press("@submit")
                ->assertPresent("@msg-nif")
                ->assertSeeIn("@msg-nif", "El NIF debe ser válido.")
                ->type("@input-nif", "654B")
                ->assertInputValue("@input-nif", "654B")
                ->assertSeeIn("@msg-nif", "El NIF debe ser válido.");
            $browser
                ->type("@input-email", "correo.com")
                ->assertInputValue("@input-email", "correo.com")
                ->press("@submit")
                ->assertPresent("@msg-email")
                ->assertSeeIn("@msg-email", "El correo debe ser válido.")
                ->type("@input-email", "correo@dom")
                ->assertInputValue("@input-email", "correo@dom")
                ->assertSeeIn("@msg-email", "El correo debe ser válido.");
            $browser
                ->type("@input-tel", "1234")
                ->assertInputValue("@input-tel", "1234")
                ->press("@submit")
                ->assertPresent("@msg-tel")
                ->assertSeeIn(
                    "@msg-tel",
                    "El número de teléfono debe ser válido."
                )
                ->type("@input-tel", "9160071")
                ->assertInputValue("@input-tel", "9160071")
                ->assertSeeIn(
                    "@msg-tel",
                    "El número de teléfono debe ser válido."
                );
            $browser
                ->type("@input-codigo", "acb210")
                ->assertInputValue("@input-codigo", "acb210")
                ->press("@submit")
                ->assertPresent("@msg-codigo")
                ->assertSeeIn("@msg-codigo", "Este campo debe ser válido.")
                ->type("@input-codigo", "81726ks")
                ->assertInputValue("@input-codigo", "81726ks")
                ->assertSeeIn("@msg-codigo", "Este campo debe ser válido.");

            $browser
                ->visit(
                    new Form(
                        recurso: "empresas",
                        accion: "edit",
                        id: $this->instFull->id
                    )
                )
                ->type("@input-ropo_nro", "12354")
                ->assertInputValue("@input-ropo_nro", "12354")
                ->press("@submit")
                ->assertPresent("@msg-ropo_nro")
                ->assertSeeIn(
                    "@msg-ropo_nro",
                    "La identificación ROPO debe estar en el formato adecuado"
                )
                ->type("@input-ropo_nro", "SS/1")
                ->assertInputValue("@input-ropo_nro", "SS/1")
                ->assertSeeIn(
                    "@msg-ropo_nro",
                    "La identificación ROPO debe estar en el formato adecuado"
                );
        });
    }

    public function testLlenadoVacio(): void
    {
        $data = [
            "tel" => str_replace(" ", "", fake()->tollFreeNumber()),
            "cod" => fake()->numerify("#####"),
            "dir" => fake()->address(),
            "obsrv" => fake()->sentence(),
        ];

        $this->browse(function (Browser $browser) use ($data) {
            $browser->visit(
                new Form(
                    recurso: "empresas",
                    accion: "edit",
                    id: $this->instParcial->id
                )
            );

            $browser
                ->type("@input-tel", $data["tel"])
                ->type("@input-codigo", $data["cod"])
                ->type("@txt-direccion", $data["dir"])
                ->type("@txt-observaciones", $data["obsrv"])
                ->press("@submit")
                ->pause(1250)
                ->assertPathIs("/app/recurso/empresas")
                ->pause(250)
                ->assertSee("se ha editado exitosamente");
        });

        $this->assertDatabaseHas("empresas", [
            "id" => $this->instParcial->id,
            "tel" => $data["tel"],
            "codigo" => $data["cod"],
            "direccion" => $data["dir"],
            "observaciones" => $data["obsrv"],
        ]);
    }

    public function testCampoVaciado(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(
                new Form(
                    recurso: "empresas",
                    accion: "edit",
                    id: $this->instFull->id
                )
            );
            $browser
                ->click("@input-tel")
                ->withKeyboard(function (Keyboard $keyboard) {
                    $telLength = strlen($this->instFull->tel);
                    for ($i = 0; $i < $telLength; $i++) {
                        $keyboard->press(parent::KEYS["backspace"]);
                    }
                })
                ->assertInputValue("@input-tel", "")
                ->press("@submit")
                ->pause(1250)
                ->assertPathIs("/app/recurso/empresas")
                ->pause(250)
                ->assertSee("se ha editado exitosamente");
        });

        $this->assertDatabaseHas("empresas", [
            "id" => $this->instFull->id,
            "tel" => null,
        ]);
    }

    public function testEditExitoso(): void
    {
        $dataToUpdate = [
            "nombre" => fake()->company(),
            "nif" => fake()->vat(),
            "email" => fake()->companyEmail(),
            "tel" => str_replace(" ", "", fake()->tollFreeNumber()),
            "codigo" => fake()->numerify("#####"),
            "perfil" => fake()->randomElement(Empresa::PERFILES),
            "direccion" => fake()->address(),
            "observaciones" => fake()->sentence(),
            "ropo" => [
                "capacitacion" => fake()->randomElement(
                    Empresa::CAPACITACIONES_ROPO
                ),
                "nro" => fake()->boolean()
                    ? fake()->regexify("[0-9]{7,12}[S]?[ASTU]")
                    : fake()->regexify("[0-9]{1,3}/[0-9]{1,3}"),
                "caducidad" => fake()->dateTimeBetween("now", "+6 years"),
            ],
        ];

        $this->browse(function (Browser $browser) use ($dataToUpdate) {
            $browser->visit(
                new Form(
                    recurso: "empresas",
                    accion: "edit",
                    id: $this->instFull->id
                )
            );

            $browser
                ->type("@input-nombre", $dataToUpdate["nombre"])
                ->assertInputValue("@input-nombre", $dataToUpdate["nombre"])
                ->type("@input-nif", $dataToUpdate["nif"])
                ->assertInputValue("@input-nif", $dataToUpdate["nif"])
                ->type("@input-email", $dataToUpdate["email"])
                ->assertInputValue("@input-email", $dataToUpdate["email"])
                ->type("@input-tel", $dataToUpdate["tel"])
                ->assertInputValue("@input-tel", $dataToUpdate["tel"])
                ->type("@input-codigo", $dataToUpdate["codigo"])
                ->assertInputValue("@input-codigo", $dataToUpdate["codigo"])
                ->type("@txt-direccion", $dataToUpdate["direccion"])
                ->assertInputValue("@txt-direccion", $dataToUpdate["direccion"])
                ->type("@txt-observaciones", $dataToUpdate["observaciones"])
                ->assertInputValue(
                    "@txt-observaciones",
                    $dataToUpdate["observaciones"]
                )
                ->selectByName("perfil", $dataToUpdate["perfil"])
                ->assertSelectedByName("perfil", $dataToUpdate["perfil"]);

            $browser
                ->type("@input-ropo_nro", $dataToUpdate["ropo"]["nro"])
                ->assertInputValue(
                    "@input-ropo_nro",
                    $dataToUpdate["ropo"]["nro"]
                )
                ->selectByName(
                    "ropo.capacitacion",
                    $dataToUpdate["ropo"]["capacitacion"]
                )
                /** Implementar seleccion de fecha */
                ->press("@submit")
                ->pause(1250)
                ->assertPathIs("/app/recurso/empresas")
                ->pause(250)
                ->assertSee("se ha editado exitosamente");
        });

        $this->assertDatabaseHas("empresas", [
            "id" => $this->instFull->id,
            "nombre" => $dataToUpdate["nombre"],
            "nif" => $dataToUpdate["nif"],
            "email" => $dataToUpdate["email"],
            "tel" => $dataToUpdate["tel"],
            "codigo" => $dataToUpdate["codigo"],
            "perfil" => $dataToUpdate["perfil"],
            "direccion" => $dataToUpdate["direccion"],
            "observaciones" => $dataToUpdate["observaciones"],
        ]);
        $this->assertDatabaseHas(Empresa::ROPO_TABLE, [
            "empresa_id" => $this->instFull->id,
            "nro" => $dataToUpdate["ropo"]["nro"],
            "capacitacion" => $dataToUpdate["ropo"]["capacitacion"],
        ]);
    }
}
