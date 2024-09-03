<?php

namespace Tests\Browser\Edit;

use App\Models\Maquina;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Keyboard;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\Recursos\Form;
use Tests\DuskTestCase;
use Illuminate\Support\Arr;

class EditMaquinaTest extends DuskTestCase
{
    protected array $PARAMS;
    public Model $row;

    public function setUp(): void
    {
        parent::setUp();
        $this->row = Maquina::factory(1, [
            "tipo_id" => 1,
        ])
            ->create()
            ->first();
        $this->PARAMS = ["maquina", "edit", $this->row->id];
    }

    public function testAcceso(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(...$this->PARAMS);
        });
    }

    public function testAccesibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser->within(new Navbar(), function (Browser $browser) {
                $browser
                    ->assertPresent("@navbar")
                    ->assertPresent("@acc-home")
                    ->assertPresent("@acc-recursos")
                    ->assertPresent("@acc-config");
            });

            $browser
                ->assertPresent("@breadcrumb")
                ->assertPresent("@title")
                ->assertPresent("@form-edit-{$this->PARAMS[2]}")
                ->assertPresent("@badge-createdAt")
                ->assertPresent("@badge-updatedAt");

            $browser
                ->assertPresent("@label-nombre")
                ->assertPresent("@label-matricula")
                ->assertPresent("@label-tipo")
                ->assertPresent("@label-fabricante")
                ->assertPresent("@label-modelo")
                ->assertPresent("@label-marca")
                ->assertPresent("@label-roma")
                ->assertPresent("@label-nro_serie")
                ->assertPresent("@label-cad_iteaf")
                ->assertPresent("@label-observaciones");

            $browser
                ->assertPresent("@input-nombre")
                ->assertPresent("@input-matricula")
                ->assertPresent("@trigger-tipo")
                ->assertPresentByName("select", "tipo")
                ->assertPresent("@input-fabricante")
                ->assertPresent("@input-modelo")
                ->assertPresent("@input-marca")
                ->assertPresent("@input-roma")
                ->assertPresent("@input-nro_serie")
                ->assertPresent("@input-cad_iteaf")
                ->assertPresent("@txt-observaciones");
        });
    }

    public function testVisibilidad(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser->within(new Navbar(), function (Browser $browser) {
                $browser
                    ->assertVisible("@navbar")
                    ->assertVisible("@acc-home")
                    ->assertVisible("@acc-recursos")
                    ->assertVisible("@acc-config");
            });

            $browser
                ->assertVisible("@breadcrumb")
                ->assertVisible("@title")
                ->assertVisible("@form-edit-{$this->PARAMS[2]}")
                ->assertVisible("@badge-createdAt")
                ->assertVisible("@badge-updatedAt");

            $browser
                ->assertVisible("@label-nombre")
                ->assertVisible("@label-matricula")
                ->assertVisible("@label-tipo")
                ->assertVisible("@label-fabricante")
                ->assertVisible("@label-modelo")
                ->assertVisible("@label-marca")
                ->assertVisible("@label-roma")
                ->assertVisible("@label-nro_serie")
                ->assertVisible("@label-cad_iteaf")
                ->assertVisible("@label-observaciones");

            $browser
                ->assertVisible("@input-nombre")
                ->assertVisible("@input-matricula")
                ->assertVisible("@trigger-tipo")
                ->assertVisibleByName("select", "tipo")
                ->assertVisible("@input-fabricante")
                ->assertVisible("@input-modelo")
                ->assertVisible("@input-marca")
                ->assertVisible("@input-roma")
                ->assertVisible("@input-nro_serie")
                ->assertVisible("@trigger-cad_iteaf")
                ->assertVisible("@txt-observaciones");
        });
    }

    public function testCamposHabilitados(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->assertEnabled("@input-nombre")
                ->assertEnabled("@input-matricula")
                ->assertEnabled("@trigger-tipo")
                ->assertEnabledByName("select", "tipo")
                ->assertEnabled("@input-fabricante")
                ->assertEnabled("@input-modelo")
                ->assertEnabled("@input-marca")
                ->assertEnabled("@input-roma")
                ->assertEnabled("@input-nro_serie")
                ->assertEnabled("@trigger-cad_iteaf")
                ->assertEnabled("@txt-observaciones");
        });
    }

    public function testValidacionInformacion(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->assertInputValue("@input-nombre", $this->row->nombre)
                ->assertInputValue("@input-matricula", $this->row->matricula)
                ->assertSeeIn("@trigger-tipo", $this->row->tipo)
                ->assertInputValue("@input-fabricante", $this->row->fabricante)
                ->assertInputValue("@input-modelo", $this->row->modelo)
                ->assertInputValue("@input-marca", $this->row->marca)
                ->assertInputValue("@input-roma", $this->row->roma)
                ->assertInputValue("@input-nro_serie", $this->row->nro_serie)
                ->assertSeeIn(
                    "@trigger-cad_iteaf",
                    Carbon::parse($this->row->cad_iteaf)->format("d/m/Y")
                )
                ->assertInputValue(
                    "@txt-observaciones",
                    $this->row->observaciones
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

            for ($i = 0; $i < strlen($this->row->matricula); $i++) {
                $browser->keys("@input-matricula", "{backspace}");
            }
            $browser->assertInputValue("@input-matricula", "");

            $browser
                ->press("@submit")
                ->assertSeeIn("@msg-nombre", "El nombre es requerido")
                ->assertSeeIn("@msg-matricula", "La matrícula es requerida");
        });
    }

    public function testCamposVaciados(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            for ($i = 0; $i < strlen($this->row->nro_serie); $i++) {
                $browser->keys("@input-nro_serie", "{backspace}");
            }
            $browser->assertInputValue("@input-nro_serie", "");
            for ($i = 0; $i < strlen($this->row->fabricante); $i++) {
                $browser->keys("@input-fabricante", "{backspace}");
            }
            $browser->assertInputValue("@input-fabricante", "");
            for ($i = 0; $i < strlen($this->row->marca); $i++) {
                $browser->keys("@input-marca", "{backspace}");
            }
            $browser->assertInputValue("@input-marca", "");
            for ($i = 0; $i < strlen($this->row->modelo); $i++) {
                $browser->keys("@input-modelo", "{backspace}");
            }
            $browser->assertInputValue("@input-modelo", "");
            for ($i = 0; $i < strlen($this->row->roma); $i++) {
                $browser->keys("@input-roma", "{backspace}");
            }
            $browser->assertInputValue("@input-roma", "");
            for ($i = 0; $i < strlen($this->row->observaciones); $i++) {
                $browser->keys("@txt-observaciones", "{backspace}");
            }
            $browser->assertInputValue("@txt-observaciones", "");

            $browser
                ->press("@submit")
                ->pause(1000)
                ->assertRouteIs("maquina.show", ["maquina" => $this->row->id]);
        });

        $attr = Arr::only($this->row->getAttributes(), [
            "id",
            "nombre",
            "matricula",
            "tipo_id",
        ]);
        $this->assertDatabaseHas(Maquina::class, $attr);

        $attr = Arr::except($this->row->getAttributes(), [
            "id",
            "created_at",
            "updated_at",
            "nombre",
            "matricula",
            "tipo_id",
        ]);
        $this->assertDatabaseMissing(Maquina::class, $attr);
    }

    public function testEnvioInvalido(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->type("@input-nombre", "sdh$%&")
                ->type("@input-matricula", "asadsfd/%%")
                ->type("@input-modelo", "modelo/1")
                ->type("@input-marca", "marca&1")
                ->type("@input-nro_serie", "serie5s4=")
                ->press("@submit");

            $browser
                ->assertSeeIn(
                    "@msg-nombre",
                    'El nombre no debe contener: !, ", ·, %, /, \, =, +, -, *, [], {}.'
                )
                ->assertSeeIn(
                    "@msg-matricula",
                    "La matrícula sólo debe contener: letras mayúsculas, números."
                )
                ->assertSeeIn(
                    "@msg-nro_serie",
                    "El Nro. de Serie sólo debe contener: letras mayúsculas, números."
                )
                ->assertSeeIn(
                    "@msg-marca",
                    "La marca no debe contener: caracteres especiales, números."
                )
                ->assertSeeIn(
                    "@msg-modelo",
                    "El modelo no debe contener: caracteres especiales, números."
                );
        });
    }

    public function testEnvioValido(): void
    {
        $data = Maquina::factory(1, [
            "tipo_id" => 1,
            "cad_iteaf" => $this->row->cad_iteaf,
        ])
            ->make()
            ->first();
        $this->browse(function (Browser $browser) use ($data) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->type("@input-nombre", $data->nombre)
                ->type("@input-matricula", $data->matricula)
                ->type("@input-nro_serie", $data->nro_serie)
                ->type("@input-fabricante", $data->fabricante)
                ->type("@input-marca", $data->marca)
                ->type("@input-modelo", $data->modelo)
                ->type("@input-roma", $data->roma)
                ->type("@txt-observaciones", $data->observaciones)
                ->press("@submit");

            $browser
                ->pause(1000)
                ->assertRouteIs("maquina.show", ["maquina" => $this->row->id]);
        });

        $this->assertDatabaseHas(Maquina::class, ["id" => $this->row->id]);
        $this->assertDatabaseMissing(
            Maquina::class,
            Arr::except($this->row->getAttributes(), [
                "id",
                "created_at",
                "updated_at",
            ])
        );
        $this->assertDatabaseHas(
            Maquina::class,
            Arr::except($data->getAttributes(), [
                "id",
                "created_at",
                "updated_at",
            ])
        );
    }

    public function testDelete(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));

            $browser
                ->assertPresent("#destroy")
                ->assertVisible("#destroy")
                ->assertEnabled("#destroy")
                ->click("#destroy")
                ->pause(2500);

            $browser->assertRouteIs("maquina.index");
        });

        $this->assertDatabaseMissing(
            Maquina::class,
            $this->row->getAttributes()
        );
    }
}
