<?php

namespace Nord\ImageManipulationService\Tests\Http\Middleware;

use Illuminate\Http\Request;
use Nord\ImageManipulationService\Http\Middleware\ImageUploadValidatorMiddleware;
use Nord\ImageManipulationService\Tests\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ImageUploadValidatorMiddlewareTest
 * @package Nord\ImageManipulationService\Tests\Http\Middleware
 */
class ImageUploadValidatorMiddlewareTest extends TestCase
{

    /**
     * @expectedException \Nord\ImageManipulationService\Exceptions\ImageUploadException
     * @expectedExceptionMessage No image specified
     */
    public function testMissingFile()
    {
        $middleware = new ImageUploadValidatorMiddleware();
        $request    = new Request();

        $middleware->handle($request, function() {

        });
    }


    /**
     * @expectedException \Nord\ImageManipulationService\Exceptions\ImageUploadException
     * @expectedExceptionMessage Image could not be uploaded, please try again
     */
    public function testInvalidFile()
    {
        $middleware = new ImageUploadValidatorMiddleware();
        $request    = new Request();
        $request->files->add([
            'image' => $this->getFailedUploadedFile(),
        ]);

        $middleware->handle($request, function() {

        });
    }


    /**
     * @return UploadedFile
     */
    private function getFailedUploadedFile(): UploadedFile
    {
        return new UploadedFile(__FILE__, 'image.jpg', 'image/jpeg', 100, UPLOAD_ERR_PARTIAL, true);
    }

}
