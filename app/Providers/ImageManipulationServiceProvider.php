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
            // Build dependencies
            $glideServer    = $app->make(Server::class);
            $presetService  = $app->make(PresetService::class);
            $filePathHelper = $app->make(FilePathHelper::class);
            $mimeTypeHelper = $app->make(MimeTypeHelper::class);
            $guzzleClient   = new Client([
                // Don't wait forever for connections to succeed
                'connect_timeout' => env('HTTP_CLIENT_CONNECT_TIMEOUT_SECONDS', 10),
            ]);

            return new ImageManipulationService(
                $glideServer, $presetService, $filePathHelper,
                $guzzleClient, $mimeTypeHelper);
        });
    }

}
