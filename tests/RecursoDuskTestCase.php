<?php

namespace Tests;

use App\Models\User;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Laravel\Dusk\Browser;
use Laravel\Dusk\TestCase as BaseTestCase;
use PHPUnit\Framework\Attributes\BeforeClass;
use Tests\Browser\Components\Navbar;
use Tests\Browser\Pages\Recursos\Form;

abstract class RecursoDuskTestCase extends BaseTestCase
{
    protected $user;
    public string $table;
    protected array $PARAMS;
    public string $class;
    public string $recurso;
    public Model $row;
    public bool $hasDeleteBtn = false;

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
        $this->browse(function (Browser $browser) {
            $browser->visit(new Form(...$this->PARAMS));
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
        });
    }

    public function testDelete(): void
    {
        echo "Dentro de {" . __METHOD__ . "}" . PHP_EOL;
        if ($this->hasDeleteBtn) {
            if ($this->PARAMS[1] === "edit") {
                echo "Ejecutando test en Edit..." . PHP_EOL;
                $this->browse(function (Browser $browser) {
                    $browser->visit(new Form(...$this->PARAMS));
                    $browser
                        ->assertPresent("#destroy")
                        ->assertVisible("#destroy")
                        ->assertEnabled("#destroy")
                        ->click("#destroy")
                        ->pause(2500);

                    $browser->assertRouteIs("{$this->recurso}.index");
                });

                $this->assertDatabaseMissing(
                    $this->class,
                    $this->row->getAttributes()
                );
            } elseif ($this->PARAMS[1] === "show") {
                echo "Ejecutando test en Show..." . PHP_EOL;
                $this->browse(function (Browser $browser) {
                    $browser->visit(new Form(...$this->PARAMS));

                    $browser->click("@badge-destroy")->pause(1000);

                    $browser
                        ->assertPresent("#delete-dialog")
                        ->assertVisible("#delete-dialog")
                        ->assertSeeIn(
                            "#delete-dialog",
                            "Confirmación para eliminar"
                        );

                    $browser
                        ->press("#delete-dialog #delete-cancel")
                        ->pause(1000)
                        ->assertNotPresent("#delete-dialog");

                    $browser
                        ->click("@badge-destroy")
                        ->pause(1000)
                        ->click("#delete-dialog #delete-confirm")
                        ->pause(1000);
                });

                $this->assertDatabaseMissing(
                    $this->class,
                    $this->row->getAttributes()
                );
            }
        }
    }
}
