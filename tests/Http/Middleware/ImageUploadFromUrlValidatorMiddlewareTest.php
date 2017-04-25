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

        $middleware = new ImageUploadFromUrlValidatorMiddleware();
        $middleware->handle($request, function() {
            return new SymfonyResponse();
        });
    }


    /**
     * @expectedException \Nord\ImageManipulationService\Exceptions\ImageUploadException
     */
    public function testMiddlewareFails()
    {
        $middleware = new ImageUploadFromUrlValidatorMiddleware();
        $middleware->handle(new Request(), function() {

        });
    }

}
