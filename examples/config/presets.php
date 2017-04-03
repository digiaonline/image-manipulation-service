<?php

/**
 * Defines the presets that can be used as shortcuts when requesting manipulated images. Each key in the array is the
 * preset name while the value is the corresponding options for Glide.
 *
 * If you don't want to use presets at all, return an empty array.
 */
return [
    'article-small' => [
        'w' => 400,
        'h' => 300,
    ],
    'article-large' => [
        'w' => 700,
        'h' => 500,
    ],
];
