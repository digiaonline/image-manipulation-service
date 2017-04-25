<?php

namespace Nord\ImageManipulationService\Http\Middleware;

use Illuminate\Http\Request;
use Nord\ImageManipulationService\Exceptions\ImageUploadException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ImageUploadFromUrlValidatorMiddleware
 * @package Nord\ImageManipulationService\Http\Middleware
 */
class ImageUploadFromUrlValidatorMiddleware
{

    /**
     * @param Request  $request
     * @param \Closure $next
     *
     * @return Response
     * @throws ImageUploadException
     */
    public function handle(Request $request, \Closure $next): Response
    {
        if (!$request->has('url')) {
            throw new ImageUploadException('No image URL specified');
        }

        return $next($request);
    }

}
