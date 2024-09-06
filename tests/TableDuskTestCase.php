<?php

namespace Tests;

use App\Models\User;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Dusk\Browser;
use Laravel\Dusk\TestCase as BaseTestCase;
use PHPUnit\Framework\Attributes\BeforeClass;
use Schema;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\Recursos\Table;

abstract class TableDuskTestCase extends BaseTestCase
{
    protected $user;
    public string $recurso;
    public string $class;
    public string $seederClass;
    public bool $hasRopo = false;

    /**
     * Prepare for Dusk test execution.
     */
    #[BeforeClass]
    public static function prepare(): void
    {
        if (!static::runningInSail()) {
            static::startChromeDriver(["--port=9515"]);
        }
    }

    /**
     * Create the RemoteWebDriver instance.
     */
    protected function driver(): RemoteWebDriver
    {
        $options = (new ChromeOptions())->addArguments(
            collect([
                $this->shouldStartMaximized()
                    ? "--start-maximized"
                    : "--window-size=1920,1080",
                "--disable-search-engine-choice-screen",
            ])
                ->unless($this->hasHeadlessDisabled(), function (
                    Collection $items
                ) {
                    return $items->merge(["--disable-gpu", "--headless=new"]);
                })
                ->all()
        );

        return RemoteWebDriver::create(
            $_ENV["DUSK_DRIVER_URL"] ??
                (env("DUSK_DRIVER_URL") ?? "http://localhost:9515"),
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY,
                $options
            )
        );
    }
    public function setUp(): void
    {
        parent::setUp();
        // Login como admin
        $this->user = User::where("email", "informatica@fruveco.com")->first();
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user);
        });
    }

    public function testAcceso(): void
    {
        echo "Dentro de {" . __METHOD__ . "}" . PHP_EOL;
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table($this->recurso));
        });
    }

    public function testAccesibilidad(): void
    {
        echo "Dentro de {" . __METHOD__ . "}" . PHP_EOL;
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table($this->recurso));

            $browser->within(new Navbar(), function (Browser $browser) {
                $browser
                    ->assertPresent("@navbar")
                    ->assertPresent("@acc-home")
                    ->assertPresent("@acc-recursos")
                    ->assertPresent("@acc-config");
            });

            $browser
                ->assertPresent("@container")
                ->assertPresent("@dt")
                ->assertPresent("@thead")
                ->assertPresent("@tbody")
                ->assertPresent("@p-indexing")
                ->assertSeeIn("@p-indexing", "Página")
                ->assertPresent("@pag-primera")
                ->assertPresent("@pag-anterior")
                ->assertPresent("@pag-siguiente")
                ->assertPresent("@pag-ultima");
        });
    }

    public function testVisibilidad(): void
    {
        echo "Dentro de {" . __METHOD__ . "}" . PHP_EOL;
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table($this->recurso));

            $browser->within(new Navbar(), function (Browser $browser) {
                $browser
                    ->assertVisible("@navbar")
                    ->assertVisible("@acc-home")
                    ->assertVisible("@acc-recursos")
                    ->assertVisible("@acc-config");
            });

            $browser
                ->assertVisible("@container")
                ->assertVisible("@dt")
                ->assertVisible("@thead")
                ->assertVisible("@tbody")
                ->assertVisible("@p-indexing")
                ->assertSeeIn("@p-indexing", "Página")
                ->assertVisible("@pag-primera")
                ->assertVisible("@pag-anterior")
                ->assertVisible("@pag-siguiente")
                ->assertVisible("@pag-ultima");
        });
    }

    public function testMenuVisibilidadColumnas(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table($this->recurso));

            $browser
                ->assertPresent("@v-btn")
                ->assertVisible("@v-btn")
                ->assertEnabled("@v-btn")
                ->click("@v-btn")
                ->pause(1000)
                ->assertPresent("@radix-popper")
                ->assertVisible("@radix-popper")
                ->assertPresent("@radix-menu-item-checkbox");
        });
    }

    public function testMenuFiltros(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table($this->recurso));

            $browser
                ->assertPresent("@f-btn")
                ->assertVisible("@f-btn")
                ->assertEnabled("@f-btn")
                ->click("@f-btn")
                ->pause(1000)
                ->assertPresent("@f-content")
                ->assertVisible("@f-content")
                ->assertPresent("@f-title")
                ->assertVisible("@f-title")
                ->assertPresent("@f-descrip")
                ->assertVisible("@f-descrip")
                ->assertPresent("@f-close")
                ->assertVisible("@f-close")
                ->assertPresent("@f-reset")
                ->assertVisible("@f-reset");
        });
    }

    public function testMenuPaginacion(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Table($this->recurso));

            $browser
                ->assertPresent("@p-container")
                ->assertPresent("@p-size-btn")
                ->assertEnabled("@p-size-btn")
                ->click("@p-size-btn")
                ->pause(750)
                ->assertPresent("@radix-popper")
                ->assertVisible("@radix-popper")
                ->assertPresent("@radix-item:nth-child(n)");
        });
    }

    public function testMenuFilas(): void
    {
        Schema::disableForeignKeyConstraints();
        $this->class::truncate();
        if ($this->hasRopo) {
            DB::table($this->class::ROPO_TABLE)->truncate();
        }

        $this->seed($this->seederClass);

        $this->browse(function (Browser $browser) {
            $browser->visit(new Table($this->recurso));

            $browser
                ->assertPresent("@r-menu")
                ->assertEnabled("@r-menu")
                ->click("@r-menu")
                ->pause(750)
                ->assertPresent("@radix-popper")
                ->assertVisible("@radix-popper")
                ->assertPresent("@acc-show")
                ->assertPresent("@acc-edit")
                ->assertPresent("@acc-destroy")
                ->assertVisible("@acc-show")
                ->assertVisible("@acc-edit")
                ->assertVisible("@acc-destroy");
        });
    }

    public function testContenidoFilas(): void
    {
        Schema::disableForeignKeyConstraints();
        $this->class::truncate();
        if ($this->hasRopo) {
            DB::table($this->class::ROPO_TABLE)->truncate();
        }

        $this->assertDatabaseEmpty((new $this->class())->getTable());

        $this->browse(function (Browser $browser) {
            $browser->visit(new Table($this->recurso));

            $browser
                ->assertPresent("@dt")
                ->assertVisible("@dt")
                ->assertSeeIn("@tbody", "Sin registros.");
        });

        $this->seed($this->seederClass);

        $this->browse(function (Browser $browser) {
            $browser->visit(new Table($this->recurso));

            $browser
                ->assertPresent("@dt")
                ->assertVisible("@dt")
                ->assertDontSeeIn("@tbody", "Sin registros.");
        });
    }

    public function testGoToCreate(): void
    {
        $this->browse(function (Browser $browser) {
            $browser
                ->visit(new Table($this->recurso))
                ->click("@acc-create")
                ->pause(750)
                ->assertUrlIs(route("{$this->recurso}.create"));
        });
    }
}
