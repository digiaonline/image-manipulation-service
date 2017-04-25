<?php

namespace Nord\ImageManipulationService\Tests\Helpers;

use Nord\ImageManipulationService\Helpers\UriHelper;
use Nord\ImageManipulationService\Tests\TestCase;

/**
 * Class UriHelperTest
 * @package Nord\ImageManipulationService\Tests\Helpers
 */
class UriHelperTest extends TestCase
{

    /**
     * Tests swapBaseUrl()
     *
     * @param $originalUrl
     * @param $targetBaseUrl
     * @param $expectedUrl
     *
     * @dataProvider swapBaseUrlDataProvider
     *
     */
    public function testSwapBaseUrl($originalUrl, $targetBaseUrl, $expectedUrl)
    {
        $uriHelper = new UriHelper();

        $this->assertEquals($expectedUrl, $uriHelper->swapBaseUrl($originalUrl, $targetBaseUrl));
    }


    /**
     * @param string $url
     * @param string $expectedFilename
     *
     * @dataProvider getFilenameDataProvider
     */
    public function testGetFilename(string $url, string $expectedFilename)
    {
        $uriHelper = new UriHelper();

        $this->assertEquals($expectedFilename, $uriHelper->getFilename($url));
    }


    /**
     * @return array
     */
    public function swapBaseUrlDataProvider()
    {
        return [
            ['http://localhost/foo/bar/test.jpg', 'http://www.example.com', 'http://www.example.com/foo/bar/test.jpg'],
            [
                'http://localhost:8080/foo/bar/test.jpg',
                'http://www.example.com',
                'http://www.example.com/foo/bar/test.jpg',
            ],
            [
                'http://localhost:8080/foo/bar/test.jpg',
                'https://www.example.com',
                'https://www.example.com/foo/bar/test.jpg',
            ],
        ];
    }


    /**
     * @return array
     */
    public function getFilenameDataProvider()
    {
        return [
            ['http://example.com/foo/bar/baz.jpg', 'baz.jpg'],
            ['http://example.com/foo/baz.jpg', 'baz.jpg'],
            ['http://example.com/baz.jpg', 'baz.jpg'],
            ['http://example.com//baz.jpg', 'baz.jpg'],
            ['http://example.com/', ''],
        ];
    }

}
