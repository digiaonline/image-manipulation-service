<?php

namespace Nord\ImageManipulationService\Tests\Helpers;

use Nord\ImageManipulationService\Helpers\MimeTypeHelper;
use Nord\ImageManipulationService\Tests\TestCase;

/**
 * Class MimeTypeHelperTest
 * @package Nord\ImageManipulationService\Tests\Helpers
 */
class MimeTypeHelperTest extends TestCase
{

    /**
     * Tests that the MIME type can actually be guessed from a stream when it should be possible
     */
    public function testGuessMimeTypeCorrectly()
    {
        // Create a stream to a test image
        $stream = fopen(__DIR__ . '/../Resources/pexels-photo-211758.jpeg', 'r');

        $mimeTypeHelper = new MimeTypeHelper();
        $this->assertEquals('image/jpeg', $mimeTypeHelper->guessMimeTypeFromStream($stream));
    }

}
