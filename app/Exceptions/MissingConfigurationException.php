<?php

namespace Nord\ImageManipulationService\Exceptions;

/**
 * Class MissingConfigurationException
 * @package Nord\ImageManipulationService\Exceptions
 */
class MissingConfigurationException extends BaseException
{

    /**
     * MissingConfigurationException constructor.
     *
     * @param string $file
     */
    public function __construct(string $file)
    {
        parent::__construct('Configuration file "' . $file . '" is missing');
    }
}
