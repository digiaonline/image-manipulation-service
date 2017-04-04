<?php

namespace Nord\ImageManipulationService\Tests;

use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;

/**
 * Class NeedsGlideConfiguration
 * @package Nord\ImageManipulationService\Tests
 */
trait NeedsGlideConfiguration
{

    /**
     *
     */
    public function configureGlide()
    {
        config([
            'glide' => [
                'source' => new Filesystem(new MemoryAdapter()),
                'cache'  => new Filesystem(new MemoryAdapter()),
            ],
        ]);
    }

}
