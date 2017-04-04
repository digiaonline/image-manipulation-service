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
     * @dataProvider dataProvider
     *
     */
    public function testSwapBaseUrl($originalUrl, $targetBaseUrl, $expectedUrl)
    {
        $uriHelper = new UriHelper();

        $this->assertEquals($expectedUrl, $uriHelper->swapBaseUrl($originalUrl, $targetBaseUrl));
    }


    /**
     * @return array
     */
    public function dataProvider()
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

}
