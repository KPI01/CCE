<?php

namespace Tests;

use App\Models\User;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Collection;
use Laravel\Dusk\TestCase as BaseTestCase;
use PHPUnit\Framework\Attributes\BeforeClass;
use Laravel\Dusk\Browser;

abstract class DuskTestCase extends BaseTestCase
{
    protected $user;

    /**
     * Prepare for Dusk test execution.
     */
    #[BeforeClass]
    public static function prepare(): void
    {
        if (!static::runningInSail()) {
            static::startChromeDriver();
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
            ])
                ->unless($this->hasHeadlessDisabled(), function (
                    Collection $items
                ) {
                    return $items->merge(["--disable-gpu", "--headless=new"]);
                })
                ->all()
        );

        return RemoteWebDriver::create(
            $_ENV["DUSK_DRIVER_URL"] ?? "http://127.0.0.1:9515",
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY,
                $options
            )
        );
    }

    public function setUp(): void
    {
        parent::setUp();

        // Login como informatica
        $this->user = User::where("email", "informatica@fruveco.com")->first();
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user);
        });
    }
}
