<?php

namespace Nord\ImageManipulationService\Tests\Providers;

use League\Glide\Server;
use Nord\ImageManipulationService\Tests\TestCase;

/**
 * Class GlideServiceProviderTest
 * @package Nord\ImageManipulationService\Tests\Providers
 */
class GlideServiceProviderTest extends TestCase
{

    /**
     * @expectedException \Nord\ImageManipulationService\Exceptions\MissingConfigurationException
     * @expectedExceptionMessageRegExp "glide"
     */
    public function testMissingGlideConfiguration()
    {
        // Clear the configuration
        config(['glide' => []]);

        $this->app->make(Server::class);
    }


    /**
     * Tests that register returns an actual instance
     */
    public function testRegister()
    {
        $this->assertInstanceOf(Server::class, $this->app->make(Server::class));
    }

}
