<?php

namespace Nord\ImageManipulationService\Http\Middleware;

use Illuminate\Http\Request;
use Nord\ImageManipulationService\Exceptions\ImageUploadException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ImageUploadFromFileValidatorMiddleware
 * @package Nord\ImageManipulationService\Http\Middleware
 */
class ImageUploadFromFileValidatorMiddleware
{

    /**
     * @var array
     */
    private static $validMimeTypes = [
        'image/gif',
        'image/jpeg',
        'image/png',
    ];


    /**
     * @param Request  $request
     * @param \Closure $next
     *
     * @return Response
     * @throws ImageUploadException
     */
    public function handle(Request $request, \Closure $next): Response
    {
        if (!$request->hasFile('image')) {
            throw new ImageUploadException('No image specified');
        }

        if (!$request->file('image')->isValid()) {
            throw new ImageUploadException('Image could not be uploaded, please try again');
        }

        if (!in_array($request->file('image')->getMimeType(), self::$validMimeTypes)) {
            throw new ImageUploadException('Invalid MIME type, valid types are: ' . $this->getValidMimeTypesString());
        }

        return $next($request);
    }


    /**
     * @return string
     */
    private function getValidMimeTypesString(): string
    {
        return implode(', ', self::$validMimeTypes);
    }

}
