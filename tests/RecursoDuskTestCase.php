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
            static::startChromeDriver(arguments: ["--port=9515"]);
        }
    }

    /**
     * Create the RemoteWebDriver instance.
     */
    protected function driver(): RemoteWebDriver
    {
        $options = (new ChromeOptions())->addArguments(
            arguments: collect(
                value: [
                    $this->shouldStartMaximized()
                        ? "--start-maximized"
                        : "--window-size=1920,1080",
                    "--disable-search-engine-choice-screen",
                ]
            )
                ->unless(
                    value: $this->hasHeadlessDisabled(),
                    callback: function (Collection $items): Collection {
                        return $items->merge(
                            items: ["--disable-gpu", "--headless=new"]
                        );
                    }
                )
                ->all()
        );

        return RemoteWebDriver::create(
            selenium_server_url: $_ENV["DUSK_DRIVER_URL"] ??
                (env(key: "DUSK_DRIVER_URL") ?? "http://localhost:9515"),
            desired_capabilities: DesiredCapabilities::chrome()->setCapability(
                name: ChromeOptions::CAPABILITY,
                value: $options
            )
        );
    }
    public function setUp(): void
    {
        parent::setUp();
        // Login como admin
        $this->user = User::where(
            column: "email",
            operator: "informatica@fruveco.com"
        )->first();
        $this->browse(
            callback: function (Browser $browser): void {
                $browser->loginAs(userId: $this->user);
            }
        );
    }

    public function testAcceso(): void
    {
        echo "Dentro de {" . __METHOD__ . "}" . PHP_EOL;
        $this->browse(
            callback: function (Browser $browser): void {
                $browser->visit(url: new Form(...$this->PARAMS));
            }
        );
    }

    public function testAccesibilidad(): void
    {
        echo "Dentro de {" . __METHOD__ . "}" . PHP_EOL;
        $this->browse(
            callback: function (Browser $browser): void {
                $browser->visit(url: new Form(...$this->PARAMS));

                $browser->within(
                    selector: new Navbar(),
                    callback: function (Browser $browser): void {
                        $browser
                            ->assertPresent(selector: "@navbar")
                            ->assertPresent(selector: "@acc-home")
                            ->assertPresent(selector: "@acc-recursos")
                            ->assertPresent(selector: "@acc-config");
                    }
                );
            }
        );
    }

    public function testVisibilidad(): void
    {
        echo "Dentro de {" . __METHOD__ . "}" . PHP_EOL;
        $this->browse(
            callback: function (Browser $browser): void {
                $browser->visit(url: new Form(...$this->PARAMS));

                $browser->within(
                    selector: new Navbar(),
                    callback: function (Browser $browser): void {
                        $browser
                            ->assertVisible(selector: "@navbar")
                            ->assertVisible(selector: "@acc-home")
                            ->assertVisible(selector: "@acc-recursos")
                            ->assertVisible(selector: "@acc-config");
                    }
                );
            }
        );
    }

    public function testDelete(): void
    {
        echo "Dentro de {" . __METHOD__ . "}" . PHP_EOL;
        if ($this->PARAMS[1] === "edit") {
            echo "Ejecutando {" . __METHOD__ . "} en Edit..." . PHP_EOL;
            $this->browse(
                callback: function (Browser $browser): void {
                    $browser->visit(url: new Form(...$this->PARAMS));
                    $browser
                        ->assertPresent(selector: "#destroy")
                        ->assertVisible(selector: "#destroy")
                        ->assertEnabled(field: "#destroy")
                        ->click(selector: "#destroy")
                        ->pause(milliseconds: 2500);

                    $browser->assertRouteIs(route: "{$this->recurso}.index");
                }
            );

            $this->assertDatabaseMissing(
                table: $this->class,
                data: $this->row->getAttributes()
            );
        } elseif ($this->PARAMS[1] === "show") {
            echo "Ejecutando " . __METHOD__ . " en Show..." . PHP_EOL;
            $this->browse(
                callback: function (Browser $browser): void {
                    $browser->visit(url: new Form(...$this->PARAMS));

                    $browser
                        ->click(selector: "@badge-destroy")
                        ->pause(milliseconds: 1000);

                    $browser
                        ->assertPresent(selector: "#delete-dialog")
                        ->assertVisible(selector: "#delete-dialog")
                        ->assertSeeIn(
                            selector: "#delete-dialog",
                            text: "Confirmación para eliminar"
                        );

                    $browser
                        ->press(button: "#delete-dialog #delete-cancel")
                        ->pause(milliseconds: 1000)
                        ->assertNotPresent(selector: "#delete-dialog");

                    $browser
                        ->click(selector: "@badge-destroy")
                        ->pause(milliseconds: 1000)
                        ->click(selector: "#delete-dialog #delete-confirm")
                        ->pause(milliseconds: 1000);
                }
            );

            $this->assertDatabaseMissing(
                table: $this->class,
                data: $this->row->getAttributes()
            );
        }
    }

    public function testGoEdit(): void
    {
        echo "Dentro de {" . __METHOD__ . "}" . PHP_EOL;
        if ($this->PARAMS[1] == "show" && $this->PARAMS[2]) {
            $this->browse(
                callback: function (Browser $browser): void {
                    $browser->visit(url: new Form(...$this->PARAMS));

                    $browser
                        ->click(selector: "@badge-edit")
                        ->pause(milliseconds: 1000);

                    $browser->assertRouteIs(
                        route: "{$this->recurso}.edit",
                        parameters: [
                            $this->recurso => $this->row->id,
                        ]
                    );
                }
            );
        }
    }
}
