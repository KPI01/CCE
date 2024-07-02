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
            return $this->assertVisible($element . '[name="' . $name . '"]');
        });
        Browser::macro('assertEnabledByName', function ($element, $name) {
            return $this->assertEnabled($element . '[name="' . $name . '"]');
        });
        Browser::macro('assertSelectedByName', function ($name, $value) {
            return $this->assertSelected('select[name="' . $name . '"]', $value);
        });
        Browser::macro('assertSelectMissingOptionByName', function ($name, array | string $value) {
            if (is_array($value)) {
                return $this->assertSelectMissingOptions('select[name="' . $name . '"]', $value);
            }
            return $this->assertSelectMissingOption('select[name="' . $name . '"]', $value);
        });
        Browser::macro('assertSelectHasOptionByName', function ($name, array | string $value) {
            if (is_array($value)) {
                return $this->assertSelectHasOptions('select[name="' . $name . '"]', $value);
            }
            return $this->assertSelectHasOption('select[name="' . $name . '"]', $value);
        });
        Browser::macro('selectByName', function ($name, $value) {
            return $this->select('select[name="' . $name . '"]', $value);
        });
        
    }
}
