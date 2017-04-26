<?php

namespace Nord\ImageManipulationService\Helpers;

use League\Uri\Exception as UriException;
use League\Uri\Parser;
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


    /**
     * @param string $url
     *
     * @return string
     */
    public function getFilename(string $url): string
    {
        $uri = HttpUri::createFromString($url);

        $path  = $uri->getPath();
        $parts = explode('/', $path);

        return end($parts);
    }


    /**
     * @param string $url
     *
     * @throws UriException if the URL cannot be parsed
     */
    public function tryParse(string $url)
    {
        $parser = new Parser();
        $parser($url);
    }

}
