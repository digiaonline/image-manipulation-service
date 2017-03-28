<?php

namespace Nord\ImageManipulationService\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UnknownPresetException
 * @package Nord\ImageManipulationService\Exceptions
 */
class UnknownPresetException extends NotFoundHttpException
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
