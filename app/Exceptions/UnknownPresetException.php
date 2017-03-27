<?php

namespace Nord\ImageManipulationService\Exceptions;

/**
 * Class UnknownPresetException
 * @package Nord\ImageManipulationService\Exceptions
 */
class UnknownPresetException extends BaseException
{

    /**
     * UnknownPresetException constructor.
     *
     * @param string $preset
     */
    public function __construct($preset)
    {
        parent::__construct('Unknown preset "' . $preset . '"');
    }

}
