<?php

return [
    // Source filesystem
    'source'   => new League\Flysystem\Filesystem(new League\Flysystem\Adapter\Local(storage_path('files'))),
    // Source filesystem path prefix
    //'source_path_prefix'     => '',
    // Cache filesystem
    'cache'    => new League\Flysystem\Filesystem(new League\Flysystem\Memory\MemoryAdapter()),
    // Cache filesystem path prefix
    //'cache_path_prefix'      => '',
    // Whether to group cached images in folders
    //'group_cache_in_folders' => '',
    // Watermarks filesystem
    //'watermarks'             => null,
    // Watermarks filesystem path prefix
    //'watermarks_path_prefix' => '',
    // Image driver (gd or imagick)
    'driver'   => 'gd',
    // Image size limit
    //'max_image_size'         => '',
    // Default image manipulations
    //'defaults'               => '',
    // Preset image manipulations
    //'presets'                => '',
    // Base URL of the images
    //'base_url'               => '',
    // Response factory
    'response' => new League\Glide\Responses\LaravelResponseFactory(),
];
