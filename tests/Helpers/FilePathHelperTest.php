<?php

namespace Nord\ImageManipulationService\Tests\Helpers;

use Nord\ImageManipulationService\Helpers\FilePathHelper;
use Nord\ImageManipulationService\Tests\TestCase;

/**
 * Class FilePathHelperTest
 * @package Nord\ImageManipulationService\Tests\Helpers
 */
class FilePathHelperTest extends TestCase
{

    /**
     * @param string $prefix
     * @param string $clientOriginalName
     * @param string $clientOriginalExtension
     * @param string $expectedPath
     *
     * @dataProvider dataProvider
     */
    public function testDetermineFilePath(
        string $prefix,
        string $clientOriginalName,
        string $clientOriginalExtension,
        string $expectedPath
    ) {
        $filePathHelper = new TestFilePathHelper();

        $this->assertEquals($expectedPath,
            $filePathHelper->determineFilePath($prefix, $clientOriginalName, $clientOriginalExtension));

    }


    /**
     * Data provider for testDetermineFilePath
     */
    public function dataProvider()
    {
        return [
            ['foo/bar', 'image.jpg', 'jpg', 'foo/bar/image_XXXXX.jpg'],
            ['bar/', 'image.png', 'png', 'bar/image_XXXXX.png'],
            ['/bar/', 'image.png', 'png', 'bar/image_XXXXX.png'],
            ['/', 'image.png', 'png', 'image_XXXXX.png'],
            ['', 'image.png', 'png', 'image_XXXXX.png'],
            ['', 'image.zip.jpg', 'png', 'image.zip_XXXXX.png'],
        ];
    }

}

/**
 * Testable FilePathHelper that doesn't return random results
 *
 * @package Nord\ImageManipulationService\Tests\Helpers
 */
class TestFilePathHelper extends FilePathHelper
{

    /**
     * @inheritdoc
     */
    protected function getRandomPostfix(): string
    {
        return 'XXXXX';
    }

}
