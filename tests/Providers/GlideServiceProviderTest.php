<?php

namespace Nord\ImageManipulationService\Tests\Providers;

use League\Glide\Server;
use Nord\ImageManipulationService\Tests\NeedsGlideConfiguration;
use Nord\ImageManipulationService\Tests\TestCase;

/**
 * Class GlideServiceProviderTest
 * @package Nord\ImageManipulationService\Tests\Providers
 */
class GlideServiceProviderTest extends TestCase
{

    use NeedsGlideConfiguration;


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
        $this->configureGlide();

        $this->assertInstanceOf(Server::class, $this->app->make(Server::class));
    }

}
