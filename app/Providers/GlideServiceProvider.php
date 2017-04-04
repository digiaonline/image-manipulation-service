<?php

namespace Nord\ImageManipulationService\Providers;

use Illuminate\Support\ServiceProvider;
use League\Glide\Server;
use League\Glide\ServerFactory;
use Nord\ImageManipulationService\Exceptions\MissingConfigurationException;

/**
 * Class GlideServiceProvider
 * @package Nord\ImageManipulationService\Providers
 */
class GlideServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->configure();

        $this->app->singleton(Server::class, function() {
            // Check that the configuration file is supplied at all
            if (empty(config('glide'))) {
                throw new MissingConfigurationException('glide.php');
            }

            return ServerFactory::create(config('glide'));
        });
    }


    /**
     * Configures the service
     *
     * @throws MissingConfigurationException
     */
    private function configure()
    {
        app()->configure('glide');
    }

}
