<?php

namespace Nord\ImageManipulationService\Services;

use Nord\ImageManipulationService\Exceptions\UnknownPresetException;

/**
 * Class PresetService
 * @package Nord\ImageManipulationService\Services
 */
class PresetService
{

    /**
     * @var array
     */
    private $presets;


    /**
     * PresetService constructor.
     *
     * @param array $presets
     */
    public function __construct(array $presets)
    {
        $this->presets = $presets;
    }


    /**
     * @param string $preset
     *
     * @return array
     *
     * @throws UnknownPresetException
     */
    public function getPresetParameters(string $preset): array
    {
        if (array_key_exists($preset, $this->presets)) {
            return $this->presets[$preset];
        }

        throw new UnknownPresetException($preset);
    }

}
