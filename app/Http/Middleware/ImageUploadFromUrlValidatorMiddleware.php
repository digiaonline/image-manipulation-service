<?php

namespace Nord\ImageManipulationService\Http\Middleware;

use Illuminate\Http\Request;
use League\Uri\Exception as UriException;
use Nord\ImageManipulationService\Exceptions\ImageUploadException;
use Nord\ImageManipulationService\Helpers\UriHelper;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ImageUploadFromUrlValidatorMiddleware
 * @package Nord\ImageManipulationService\Http\Middleware
 */
class ImageUploadFromUrlValidatorMiddleware
{

    /**
     * @var UriHelper
     */
    private $uriHelper;


    /**
     * ImageUploadFromUrlValidatorMiddleware constructor.
     *
     * @param UriHelper $uriHelper
     */
    public function __construct(UriHelper $uriHelper)
    {
        $this->uriHelper = $uriHelper;
    }


    /**
     * @param Request  $request
     * @param \Closure $next
     *
     * @return Response
     *
     * @throws ImageUploadException if there's something wrong with the request
     */
    public function handle(Request $request, \Closure $next): Response
    {
        // Check that a URL has been specified
        if (!$request->has('url')) {
            throw new ImageUploadException('No image URL specified');
        }

        // Check that the URL can be parsed properly
        try {
            $this->uriHelper->tryParse($request->get('url'));
        } catch (UriException $e) {
            throw new ImageUploadException('The specified URL could not be parsed: ' . $e->getMessage());
        }

        return $next($request);
    }

}
