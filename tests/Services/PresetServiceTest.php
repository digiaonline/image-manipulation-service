<?php

namespace Nord\ImageManipulationService\Tests\Services;

use Nord\ImageManipulationService\Services\PresetService;
use Nord\ImageManipulationService\Tests\TestCase;

/**
 * Class PresetServiceTest
 * @package Nord\ImageManipulationService\Tests\Services
 */
class PresetServiceTest extends TestCase
{

    /**
     * Tests getPresetParameters() with an unknown preset
     * @expectedException \Nord\ImageManipulationService\Exceptions\UnknownPresetException
     */
    public function testGetUnknownPresetParameters()
    {
        $presetService = new PresetService(['foo']);
        $presetService->getPresetParameters('bar');
    }


    /**
     * Tests getPresetParameters() with a known preset
     */
    public function testKnownPresetParameters()
    {
        $expectedPresetParameters = [
            'width' => 100,
        ];

        $presetService = new PresetService(['foo' => $expectedPresetParameters]);
        $this->assertEquals($expectedPresetParameters, $presetService->getPresetParameters('foo'));
    }
}
