<?php

namespace Nord\ImageManipulationService\Tests\Http\Middleware;

use Illuminate\Http\Request;
use Nord\ImageManipulationService\Http\Middleware\ImageUploadFromUrlValidatorMiddleware;
use Nord\ImageManipulationService\Tests\TestCase;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class ImageUploadFromUrlValidatorMiddlewareTest
 * @package Nord\ImageManipulationService\Tests\Http\Middleware
 */
class ImageUploadFromUrlValidatorMiddlewareTest extends TestCase
{

    /**
     * Tests that the middleware passes if the request is valid
     */
    public function testMiddlewarePasses()
    {
        $request = new Request();
        $request->setMethod('POST');
        $request->request->add([
            'url' => 'http://example.com',
        ]);

        $middleware = $this->getMiddlewareInstance();
        $middleware->handle($request, function() {
            return new SymfonyResponse();
        });
    }


    /**
     * @expectedException \Nord\ImageManipulationService\Exceptions\ImageUploadException
     * @expectedExceptionMessage No image URL specified
     */
    public function testMissingUrl()
    {
        $middleware = $this->getMiddlewareInstance();
        $middleware->handle(new Request(), function() {

        });
    }


    /**
     * @expectedException \Nord\ImageManipulationService\Exceptions\ImageUploadException
     * @expectedExceptionMessageRegExp *The specified URL could not be parsed*
     */
    public function testInvalidUrl()
    {
        $request = new Request();
        $request->setMethod('POST');
        $request->request->add([
            'url' => '{"url: "http://example.com", just invalid /"',
        ]);

        $middleware = $this->getMiddlewareInstance();
        $middleware->handle($request, function() {

        });
    }


    /**
     * @return ImageUploadFromUrlValidatorMiddleware
     */
    private function getMiddlewareInstance(): ImageUploadFromUrlValidatorMiddleware
    {
        return $this->app->make(ImageUploadFromUrlValidatorMiddleware::class);
    }

}
