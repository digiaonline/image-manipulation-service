<?php

namespace Nord\ImageManipulationService\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;
use League\Glide\Server;
use Nord\ImageManipulationService\Helpers\FilePathHelper;
use Nord\ImageManipulationService\Helpers\MimeTypeHelper;
use Nord\ImageManipulationService\Services\ImageManipulationService;
use Nord\ImageManipulationService\Services\PresetService;

/**
 * Class ImageManipulationServiceProvider
 * @package Nord\ImageManipulationService\Providers
 */
class ImageManipulationServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(ImageManipulationService::class, function (Application $app) {
            return new ImageManipulationService(
                $app->make(Server::class), $app->make(PresetService::class), $app->make(FilePathHelper::class),
                new Client(), $app->make(MimeTypeHelper::class));
        });
    }

}
