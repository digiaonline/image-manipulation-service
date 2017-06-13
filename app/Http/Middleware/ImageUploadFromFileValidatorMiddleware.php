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
    private $allowedMimeTypes;

    /**
     * ImageUploadFromFileValidatorMiddleware constructor.
     */
    public function __construct()
    {
        $this->allowedMimeTypes = config('app.allowed_upload_mime_types', []);
    }

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

        if (!in_array($request->file('image')->getMimeType(), config('app.allowed_upload_mime_types'))) {
            throw new ImageUploadException('Invalid MIME type, valid types are: ' . $this->getValidMimeTypesString());
        }

        return $next($request);
    }

    /**
     * @return string
     */
    private function getValidMimeTypesString(): string
    {
        return implode(', ', $this->allowedMimeTypes);
    }

}
