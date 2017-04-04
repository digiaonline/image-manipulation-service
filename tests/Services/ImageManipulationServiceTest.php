<?php

namespace Nord\ImageManipulationService\Tests\Services;

use Nord\ImageManipulationService\Services\ImageManipulationService;
use Nord\ImageManipulationService\Tests\NeedsGlideConfiguration;
use Nord\ImageManipulationService\Tests\TestCase;

/**
 * Class ImageManipulationServiceTest
 * @package Nord\ImageManipulationService\Tests\Services
 */
class ImageManipulationServiceTest extends TestCase
{

    use NeedsGlideConfiguration;

    /**
     * @var ImageManipulationService
     */
    private $imageManipulationService;


    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();

        $this->configureGlide();

        $this->imageManipulationService = $this->app->make(ImageManipulationService::class);
    }


    /**
     * Tests getCdnBaseUrl()
     */
    public function testGetCdnBaseUrl()
    {
        putenv('CDN_BASEURL=');
        $this->assertNull($this->imageManipulationService->getCdnBaseUrl());

        putenv('CDN_BASEURL=foo');
        $this->assertEquals('foo', $this->imageManipulationService->getCdnBaseUrl());
    }

}
