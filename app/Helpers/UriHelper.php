<?php

namespace Nord\ImageManipulationService\Helpers;

use League\Uri\Schemes\Http as HttpUri;

/**
 * Class UriHelper
 * @package Nord\ImageManipulationService\Helpers
 */
class UriHelper
{

    /**
     * @param string $originalUrl
     * @param string $targetBaseUrl
     *
     * @return string
     */
    public function swapBaseUrl(string $originalUrl, string $targetBaseUrl): string
    {
        $originalUri = HttpUri::createFromString($originalUrl);
        $targetUri   = HttpUri::createFromString($targetBaseUrl);

        return $originalUri->withScheme($targetUri->getScheme())
                           ->withHost($targetUri->getHost())
                           ->withPort($targetUri->getPort());
    }

}
