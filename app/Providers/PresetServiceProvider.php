<?php

namespace Nord\ImageManipulationService\Providers;

use Illuminate\Support\ServiceProvider;
use Nord\ImageManipulationService\Services\PresetService;

/**
 * Class PresetServiceProvider
 * @package Nord\ImageManipulationService\Providers
 */
class PresetServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(PresetService::class, function() {
            return new PresetService(config('presets', []));
        });
    }

}
