<?php

// Shows the dashboard, if enabled
$app->get('/', [
    'middleware' => \Nord\ImageManipulationService\Http\Middleware\DashboardEnabledMiddleware::class,
    'uses'       => 'DashboardController@dashboard',
]);

// Serves images based on the specified path and preset
$app->get('/preset/{preset}/{path:.*}', [
    'as'   => 'servePresetImage',
    'uses' => 'ImageController@servePresetImage',
]);

// Serves the original image based on the specified path
$app->get('/{path:.*}', [
    'as'   => 'serveOriginalImage',
    'uses' => 'ImageController@serveOriginalImage',
]);

// Stores an uploaded image to the source filesystem, then returns the path to it
$app->post('/upload', [
    'middleware' => \Nord\ImageManipulationService\Http\Middleware\ImageUploadValidatorMiddleware::class,
    'uses'       => 'ImageController@uploadImage',
]);
