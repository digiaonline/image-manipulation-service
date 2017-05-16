<?php

namespace Nord\ImageManipulationService\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 * @package Nord\ImageManipulationService\Providers
 */
class AppServiceProvider extends ServiceProvider
{

    /**
     * Registers the service provider
     */
    public function register()
    {
        app()->configure('app');
    }

}
