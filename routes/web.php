<?php

// Shows the dashboard, if enabled
$app->get('/', [
    'middleware' => \Nord\ImageManipulationService\Http\Middleware\DashboardPageEnabledMiddleware::class,
    'uses'       => 'DashboardController@dashboard',
]);

// Serves an image
$app->get('/{path:.*}', [
    'as'   => 'serveImage',
    'uses' => 'ImageController@serveImage',
]);

// Stores an uploaded image to the source filesystem, then returns the path to it
$app->post('/upload', [
    'middleware' => \Nord\ImageManipulationService\Http\Middleware\ImageUploadValidatorMiddleware::class,
    'uses'       => 'ImageController@uploadImage',
]);
