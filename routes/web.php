<?php

// Health check
$app->get('/health', function() {
    return 'OK';
});

// Shows the dashboard, if enabled
$app->get('/', [
    'middleware' => \Nord\ImageManipulationService\Http\Middleware\DashboardPageEnabledMiddleware::class,
    'uses'       => 'DashboardController@dashboard',
]);

// Shows the upload page, if enabled
$app->get('/upload', [
    'middleware' => \Nord\ImageManipulationService\Http\Middleware\UploadPageEnabledMiddleware::class,
    'uses'       => 'ImageController@index',
]);

// Serves an image
$app->get('/{path:.*}', [
    'as'         => 'serveImage',
    'middleware' => \Nord\ImageManipulationService\Http\Middleware\ServeImageAuthenticationMiddleware::class,
    'uses'       => 'ImageController@serveImage',
]);

// Stores an uploaded image to the source filesystem, then returns the path to it
$app->post('/upload', [
    'middleware' => [
        \Nord\ImageManipulationService\Http\Middleware\UploadAuthenticationMiddleware::class,
        \Nord\ImageManipulationService\Http\Middleware\ImageUploadFromFileValidatorMiddleware::class,
    ],
    'uses'       => 'ImageController@uploadImageFromFile',
]);

$app->post('/uploadFromUrl', [
    'middleware' => [
        \Nord\ImageManipulationService\Http\Middleware\UploadAuthenticationMiddleware::class,
        \Nord\ImageManipulationService\Http\Middleware\ImageUploadFromUrlValidatorMiddleware::class,
    ],
    'uses'       => 'ImageController@uploadImageFromUrl',
]);
