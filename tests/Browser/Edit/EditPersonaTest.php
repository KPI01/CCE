<?php

namespace Tests\Browser\Edit;

use App\Models\Persona;
use Laravel\Dusk\Browser;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\Recursos\Form;
use Tests\DuskTestCase;
use Laravel\Dusk\Keyboard;

class EditPersonaTest extends DuskTestCase
{
    public Persona $instFull;
    public Persona $instParcial;

    public function setUp(): void
    {
        parent::setUp();
        $this->instParcial = Persona::factory(1)
            ->state([
                "tel" => "",
                "observaciones" => "",
            ])
            ->create()
            ->first();
        $this->instFull = Persona::factory(1)->withRopo()->create()->first();
    }

    public function testAcceso(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(
                new Form(
                    recurso: "personas",
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
                    recurso: "personas",
                    accion: "edit",
                    id: $this->instFull->id
                )
            );

            $browser->within(new Navbar(), function (Browser $browser) {
                $browser
                    ->assertPresent("@nav")
                    ->assertPresent("@list")
                    ->assertPresent("@rcs-btn")
                    ->assertPresent("@conf-btn")
                    ->assertPresent("@home-btn");
            });

            $browser
                ->assertPresent("@h3-basicos")
                ->assertPresent("@form-edit-{$this->instFull->id}")
                ->assertPresent("@label-nombres")
                ->assertPresent("@input-nombres")
                ->assertPresent("@label-apellidos")
                ->assertPresent("@input-apellidos")
                ->assertPresent("@label-id_nac")
                ->assertPresent("@trigger-tipo_id_nac")
                ->assertPresentByName("select", "tipo_id_nac")
                ->assertPresent("@input-id_nac")
                ->assertPresent("@label-email")
                ->assertPresent("@input-email")
                ->assertPresent("@label-tel")
                ->assertPresent("@input-tel")
                ->assertPresent("@label-perfil")
                ->assertPresent("@trigger-perfil")
                ->assertPresentByName("select", "perfil")
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

            $browser->assertPresent("@submit")->assertEnabled("@submit");
        });
    }

    public function testVisibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(
                new Form(
                    recurso: "personas",
                    accion: "edit",
                    id: $this->instFull->id
                )
            );

            $browser->within(new Navbar(), function (Browser $browser) {
                $browser
                    ->assertVisible("@nav")
                    ->assertVisible("@list")
                    ->assertVisible("@rcs-btn")
                    ->assertVisible("@conf-btn")
                    ->assertVisible("@home-btn");
            });

            $browser
                ->assertVisible("@h3-basicos")
                ->assertVisible("@form-edit-{$this->instFull->id}")
                ->assertVisible("@label-nombres")
                ->assertVisible("@input-nombres")
                ->assertVisible("@label-apellidos")
                ->assertVisible("@input-apellidos")
                ->assertVisible("@label-id_nac")
                ->assertVisible("@trigger-tipo_id_nac")
                ->assertVisibleByName("select", "tipo_id_nac")
                ->assertVisible("@input-id_nac")
                ->assertVisible("@label-email")
                ->assertVisible("@input-email")
                ->assertVisible("@label-tel")
                ->assertVisible("@input-tel")
                ->assertVisible("@label-perfil")
                ->assertVisible("@trigger-perfil")
                ->assertVisibleByName("select", "perfil")
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
                    recurso: "personas",
                    accion: "edit",
                    id: $this->instFull->id
                )
            );

            $browser
                ->assertEnabled("@input-nombres")
                ->assertEnabled("@input-apellidos")
                ->assertEnabled("@label-id_nac")
                ->assertEnabled("@trigger-tipo_id_nac")
                ->assertEnabledByName("select", "tipo_id_nac")
                ->assertEnabled("@input-id_nac")
                ->assertEnabled("@label-email")
                ->assertEnabled("@input-email")
                ->assertEnabled("@label-tel")
                ->assertEnabled("@input-tel")
                ->assertEnabled("@label-perfil")
                ->assertEnabled("@trigger-perfil")
                ->assertEnabledByName("select", "perfil")
                ->assertEnabled("@label-observaciones")
                ->assertEnabled("@txt-observaciones");

            $browser
                ->assertEnabled("@h3-ropo")
                ->assertEnabled("@label-ropo_capacitacion")
                ->assertEnabled("@trigger-ropo_capacitacion")
                ->assertEnabledByName("select", "ropo.capacitacion")
                ->assertEnabled("@label-ropo_nro")
                ->assertEnabled("@input-ropo_nro")
                ->assertEnabled("@label-ropo_caducidad")
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
                    recurso: "personas",
                    accion: "edit",
                    id: $this->instFull->id
                )
            );

            $browser
                ->assertInputValue("@input-nombres", $this->instFull->nombres)
                ->assertInputValue(
                    "@input-apellidos",
                    $this->instFull->apellidos
                )
                ->assertSelectedByName(
                    "tipo_id_nac",
                    $this->instFull->tipo_id_nac
                )
                ->assertInputValue("@input-id_nac", $this->instFull->id_nac)
                ->assertInputValue("@input-email", $this->instFull->email)
                ->assertInputValue("@input-tel", $this->instFull->tel)
                ->assertSelectedByName("perfil", $this->instFull->perfil)
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
                    date("Y-m-d", strtotime($this->instFull->ropo["caducidad"]))
                );
        });
    }

    public function testEdicionCampos(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(
                new Form(
                    recurso: "personas",
                    accion: "edit",
                    id: $this->instFull->id
                )
            );

            $ropo_rgx1 = '^[0-9]{7,12}[S]?[ASTU]$';
            $ropo_rgx2 = '^[0-9]{1,3}/[0-9]{1,3}$';
            $fakeData = [
                "nombres" => fake()->firstName(),
                "apellidos" => fake()->lastName(),
                "tipo_id_nac" => "DNI",
                "id_nac" => fake()->dni(),
                "email" => fake()->email(),
                "tel" => str_replace(" ", "", fake()->tollFreeNumber()),
                "perfil" => fake()->randomElement(Persona::PERFILES),
                "observaciones" => fake()->text(),
                "ropo" => [
                    "capacitacion" => fake()->randomElement(
                        Persona::CAPACITACIONES_ROPO
                    ),
                    "nro" => fake()->boolean()
                        ? fake()->regexify($ropo_rgx1)
                        : fake()->regexify($ropo_rgx2),
                    "caducidad" => fake()->dateTimeBetween("now", "+4 year"),
                ],
            ];

            $browser
                ->type("@input-nombres", $fakeData["nombres"])
                ->assertInputValue("@input-nombres", $fakeData["nombres"])
                ->type("@input-apellidos", $fakeData["apellidos"])
                ->assertInputValue("@input-apellidos", $fakeData["apellidos"])
                ->assertSelectHasOptionByName(
                    "tipo_id_nac",
                    $fakeData["tipo_id_nac"]
                )
                ->selectByName("tipo_id_nac", $fakeData["tipo_id_nac"])
                ->assertSelectedByName("tipo_id_nac", $fakeData["tipo_id_nac"])
                ->type("@input-id_nac", $fakeData["id_nac"])
                ->assertInputValue("@input-id_nac", $fakeData["id_nac"])
                ->type("@input-email", $fakeData["email"])
                ->assertInputValue("@input-email", $fakeData["email"])
                ->type("@input-tel", $fakeData["tel"])
                ->assertInputValue("@input-tel", $fakeData["tel"])
                ->assertSelectHasOptionByName("perfil", $fakeData["perfil"])
                ->selectByName("perfil", $fakeData["perfil"])
                ->assertSelectedByName("perfil", $fakeData["perfil"])
                ->type("@txt-observaciones", $fakeData["observaciones"])
                ->assertInputValue(
                    "@txt-observaciones",
                    $fakeData["observaciones"]
                );

            $browser
                ->assertSelectHasOptionByName(
                    "ropo.capacitacion",
                    $fakeData["ropo"]["capacitacion"]
                )
                ->selectByName(
                    "ropo.capacitacion",
                    $fakeData["ropo"]["capacitacion"]
                )
                ->assertSelectedByName(
                    "ropo.capacitacion",
                    $fakeData["ropo"]["capacitacion"]
                )
                ->type("@input-ropo_nro", $fakeData["ropo"]["nro"])
                ->assertInputValue("@input-ropo_nro", $fakeData["ropo"]["nro"]);
            /**
             * No he llegado a una forma de implementar el test de la caducidad
             * utilizando el date picker
             */
        });
    }

    public function testEnvioRequeridoVacio(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(
                new Form(
                    recurso: "personas",
                    accion: "edit",
                    id: $this->instFull->id
                )
            );

            $browser
                ->assertInputValueIsNot("@input-nombres", "")
                ->assertInputValueIsNot("@input-apellidos", "")
                ->assertInputValueIsNot("@input-id_nac", "")
                ->assertInputValueIsNot("@input-email", "");

            $browser
                ->doubleClick("@input-nombres")
                ->withKeyboard(function (Keyboard $keyboard) {
                    $nombresLength = strlen($this->instFull->nombres);
                    for ($i = 0; $i < $nombresLength; $i++) {
                        $keyboard->press(self::KEYS["backspace"]);
                    }
                })
                ->assertInputValue("@input-nombres", "")
                ->press("@submit")
                ->assertPresent("@msg-nombres")
                ->assertSeeIn("@msg-nombres", "Este campo es requerido")
                ->type("@input-nombres", $this->instFull->nombres);
            $browser
                ->doubleClick("@input-apellidos")
                ->withKeyboard(function (Keyboard $keyboard) {
                    $apellidosLength = strlen($this->instFull->apellidos);
                    for ($i = 0; $i < $apellidosLength; $i++) {
                        $keyboard->press(self::KEYS["backspace"]);
                    }
                })
                ->assertInputValue("@input-apellidos", "")
                ->press("@submit")
                ->assertPresent("@msg-apellidos")
                ->assertSeeIn("@msg-apellidos", "Este campo es requerido")
                ->type("@input-apellidos", $this->instFull->apellidos);
            $browser
                ->click("@input-id_nac")
                ->withKeyboard(function (Keyboard $keyboard) {
                    $idNacLength = strlen($this->instFull->id_nac);
                    for ($i = 0; $i < $idNacLength; $i++) {
                        $keyboard->press(self::KEYS["backspace"]);
                    }
                })
                ->assertInputValue("@input-id_nac", "")
                ->press("@submit")
                ->assertPresent("@msg-id_nac")
                ->assertSeeIn("@msg-id_nac", "Este campo es requerido")
                ->type("@input-id_nac", $this->instFull->id_nac);
            $browser
                ->click("@input-email")
                ->withKeyboard(function (Keyboard $keyboard) {
                    $emailLength = strlen($this->instFull->email);
                    for ($i = 0; $i < $emailLength; $i++) {
                        $keyboard->press(self::KEYS["backspace"]);
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
                    recurso: "personas",
                    accion: "edit",
                    id: $this->instFull->id
                )
            );

            $browser
                ->type("@input-nombres", "abc123")
                ->assertInputValue("@input-nombres", "abc123")
                ->press("@submit")
                ->assertPresent("@msg-nombres")
                ->assertSeeIn(
                    "@msg-nombres",
                    "El nombre solo puede contener letras"
                );
            $browser
                ->type("@input-apellidos", "zxy987")
                ->assertInputValue("@input-apellidos", "zxy987")
                ->press("@submit")
                ->assertPresent("@msg-apellidos")
                ->assertSeeIn(
                    "@msg-apellidos",
                    "El apellido solo puede contener letras"
                );
            $browser
                ->type("@input-id_nac", "12354s")
                ->assertInputValue("@input-id_nac", "12354s")
                ->press("@submit")
                ->assertPresent("@msg-id_nac")
                ->assertSeeIn(
                    "@msg-id_nac",
                    "La identificación debe tener el formato adecuado"
                );
            $browser
                ->type("@input-email", "ahsgda.com")
                ->assertInputValue("@input-email", "ahsgda.com")
                ->press("@submit")
                ->assertPresent("@msg-email")
                ->assertSeeIn("@msg-email", "El correo debe ser válido");
            $browser
                ->type("@input-tel", "12354")
                ->assertInputValue("@input-tel", "12354")
                ->press("@submit")
                ->assertPresent("@msg-tel")
                ->assertSeeIn(
                    "@msg-tel",
                    "El número de teléfono debe ser válido"
                );
            $browser
                ->visit(
                    new Form(
                        recurso: "personas",
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
                    recurso: "personas",
                    accion: "edit",
                    id: $this->instFull->id
                )
            );

            $browser
                ->type("@input-nombres", "abc123")
                ->assertInputValue("@input-nombres", "abc123")
                ->press("@submit")
                ->assertPresent("@msg-nombres")
                ->assertSeeIn(
                    "@msg-nombres",
                    "El nombre solo puede contener letras"
                )
                ->type("@input-nombres", "ab")
                ->assertInputValue("@input-nombres", "ab")
                ->assertSeeIn(
                    "@msg-nombres",
                    "El nombre debe tener al menos 3 caracteres"
                );
            $browser
                ->type("@input-apellidos", "zxy987")
                ->assertInputValue("@input-apellidos", "zxy987")
                ->press("@submit")
                ->assertPresent("@msg-apellidos")
                ->assertSeeIn(
                    "@msg-apellidos",
                    "El apellido solo puede contener letras"
                )
                ->type("@input-apellidos", "xz")
                ->assertInputValue("@input-apellidos", "xz")
                ->assertSeeIn(
                    "@msg-apellidos",
                    "El apellido debe tener al menos 3 caracteres"
                );
            $browser
                ->type("@input-id_nac", "12354s")
                ->assertInputValue("@input-id_nac", "12354s")
                ->press("@submit")
                ->assertPresent("@msg-id_nac")
                ->assertSeeIn(
                    "@msg-id_nac",
                    "La identificación debe tener el formato adecuado"
                )
                ->type("@input-id_nac", "Z19845F")
                ->assertInputValue("@input-id_nac", "Z19845F")
                ->assertSeeIn(
                    "@msg-id_nac",
                    "La identificación debe tener el formato adecuado"
                );
            $browser
                ->type("@input-email", "ahsgda.com")
                ->assertInputValue("@input-email", "ahsgda.com")
                ->press("@submit")
                ->assertPresent("@msg-email")
                ->assertSeeIn("@msg-email", "El correo debe ser válido")
                ->type("@input-email", "zbc132@dominio")
                ->assertInputValue("@input-email", "zbc132@dominio")
                ->assertSeeIn("@msg-email", "El correo debe ser válido");
            $browser
                ->type("@input-tel", "12354")
                ->assertInputValue("@input-tel", "12354")
                ->press("@submit")
                ->assertPresent("@msg-tel")
                ->assertSeeIn(
                    "@msg-tel",
                    "El número de teléfono debe ser válido"
                )
                ->type("@input-tel", "6009015")
                ->assertInputValue("@input-tel", "6009015")
                ->assertSeeIn(
                    "@msg-tel",
                    "El número de teléfono debe ser válido"
                );
            $browser
                ->visit(
                    new Form(
                        recurso: "personas",
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
        $obsrv = fake()->text();
        $nro = str_replace(" ", "", fake()->tollFreeNumber());

        $this->browse(function (Browser $browser) use ($obsrv, $nro) {
            $browser->visit(
                new Form(
                    recurso: "personas",
                    accion: "edit",
                    id: $this->instParcial->id
                )
            );

            $browser
                ->type("@input-tel", $nro)
                ->type("@txt-observaciones", $obsrv)
                ->press("@submit")
                ->pause(750)
                ->assertPathIs("/app/recurso/personas")
                ->pause(250)
                ->assertSee("se ha editado exitosamente");
        });

        $this->assertDatabaseHas("personas", [
            "id" => $this->instParcial->id,
            "tel" => $nro,
            "observaciones" => $obsrv,
        ]);
    }

    public function testCampoVaciado(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(
                new Form(
                    recurso: "personas",
                    accion: "edit",
                    id: $this->instFull->id
                )
            );

            $browser
                ->click("@input-tel")
                ->withKeyboard(function (Keyboard $keyboard) {
                    $telLength = strlen($this->instFull->tel);
                    for ($i = 0; $i < $telLength; $i++) {
                        $keyboard->press(self::KEYS["backspace"]);
                    }
                })
                ->assertInputValue("@input-tel", "")
                ->press("@submit")
                ->pause(750)
                ->assertPathIs("/app/recurso/personas")
                ->pause(250)
                ->assertSee("se ha editado exitosamente");
        });

        $this->assertDatabaseHas("personas", [
            "id" => $this->instFull->id,
            "tel" => null,
        ]);
    }

    public function testEditExitoso(): void
    {
        $tipo_id_nac = fake()->randomElement(Persona::TIPO_ID_NAC);
        $dataToUpdate = [
            "nombres" => fake()->firstName(),
            "apellidos" => fake()->lastName(),
            "tipo_id_nac" => $tipo_id_nac,
            "id_nac" =>
                $tipo_id_nac === "DNI"
                    ? fake()->unique()->regexify("[0-9]{8}[A-Z]")
                    : fake()->unique()->regexify("[XYZ][0-9]{7}[XYZ]"),
            "email" => fake()->unique()->safeEmail(),
            "tel" => str_replace(" ", "", fake()->tollFreeNumber()),
            "perfil" => fake()->randomElement(Persona::PERFILES),
            "observaciones" => fake()->text(),
            "ropo" => [
                "capacitacion" => fake()->randomElement(
                    Persona::CAPACITACIONES_ROPO
                ),
                "nro" => fake()->boolean()
                    ? fake()->regexify("[0-9]{7,12}[S]?[ASTU]")
                    : fake()->regexify("[0-9]{1,3}/[0-9]{1,3}"),
                "caducidad" => fake()->dateTimeBetween("now", "+4 year"),
            ],
        ];

        $this->browse(function (Browser $browser) use ($dataToUpdate) {
            $browser->visit(
                new Form(
                    recurso: "personas",
                    accion: "edit",
                    id: $this->instFull->id
                )
            );

            $browser
                ->type("@input-nombres", $dataToUpdate["nombres"])
                ->assertInputValue("@input-nombres", $dataToUpdate["nombres"])
                ->type("@input-apellidos", $dataToUpdate["apellidos"])
                ->assertInputValue(
                    "@input-apellidos",
                    $dataToUpdate["apellidos"]
                )
                ->assertSelectHasOptionByName(
                    "tipo_id_nac",
                    $dataToUpdate["tipo_id_nac"]
                )
                ->selectByName("tipo_id_nac", $dataToUpdate["tipo_id_nac"])
                ->assertSelectedByName(
                    "tipo_id_nac",
                    $dataToUpdate["tipo_id_nac"]
                )
                ->type("@input-id_nac", $dataToUpdate["id_nac"])
                ->assertInputValue("@input-id_nac", $dataToUpdate["id_nac"])
                ->type("@input-email", $dataToUpdate["email"])
                ->assertInputValue("@input-email", $dataToUpdate["email"])
                ->type("@input-tel", $dataToUpdate["tel"])
                ->assertInputValue("@input-tel", $dataToUpdate["tel"])
                ->selectByName("perfil", $dataToUpdate["perfil"])
                ->assertSelectHasOptionByName("perfil", $dataToUpdate["perfil"])
                ->assertSelectedByName("perfil", $dataToUpdate["perfil"])
                ->type("@txt-observaciones", $dataToUpdate["observaciones"])
                ->assertInputValue(
                    "@txt-observaciones",
                    $dataToUpdate["observaciones"]
                )
                ->assertSelectHasOptionByName(
                    "ropo.capacitacion",
                    $dataToUpdate["ropo"]["capacitacion"]
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
                )
                /** Implementar forma de ingresar caducidad */
                ->press("@submit")
                ->pause(750)
                ->assertPathIs("/app/recurso/personas")
                ->pause(250)
                ->assertSee("se ha editado exitosamente");
        });

        $this->assertDatabaseHas("personas", [
            "id" => $this->instFull->id,
            "nombres" => $dataToUpdate["nombres"],
            "apellidos" => $dataToUpdate["apellidos"],
            "tipo_id_nac" => $dataToUpdate["tipo_id_nac"],
            "id_nac" => $dataToUpdate["id_nac"],
            "email" => $dataToUpdate["email"],
            "tel" => $dataToUpdate["tel"],
            "perfil" => $dataToUpdate["perfil"],
            "observaciones" => $dataToUpdate["observaciones"],
        ]);

        $this->assertDatabaseHas("persona_ropo", [
            "persona_id" => $this->instFull->id,
            "capacitacion" => $dataToUpdate["ropo"]["capacitacion"],
            "nro" => $dataToUpdate["ropo"]["nro"],
        ]);
    }
}
