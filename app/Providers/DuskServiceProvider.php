<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\Browser;

class DuskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        Browser::macro('assertPresentByName', function ($element, $name) {
            // echo $element . '[name="' . $name . '"]' . PHP_EOL;
            return $this->assertPresent($element . '[name="' . $name . '"]');
        });
        Browser::macro('assertVisibleByName', function ($element, $name) {
            // echo $element . '[name="' . $name . '"]' . PHP_EOL;
            return $this->assertVisible($element . '[name="' . $name . '"]');
        });
        Browser::macro('assertEnabledByName', function ($element, $name) {
            // echo $element . '[name="' . $name . '"]' . PHP_EOL;
            return $this->assertEnabled($element . '[name="' . $name . '"]');
        });
        Browser::macro('assertSelectedByName', function ($element, $name, $value) {
            // echo $element . '[name="' . $name . '"]' . PHP_EOL;
            return $this->assertSelected($element . '[name="' . $name . '"]', $value);
        });
    }
}
