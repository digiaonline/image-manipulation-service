<?php

namespace Nord\ImageManipulationService\Tests\Http\Middleware;

use Illuminate\Http\Request;
use Nord\ImageManipulationService\Http\Middleware\UploadPageEnabledMiddleware;

/**
 * Class UploadPageEnabledMiddlewareTest
 * @package Nord\ImageManipulationService\Tests\Http\Middleware
 */
class UploadPageEnabledMiddlewareTest extends MiddlewareTestCase
{

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    public function testWithUploadPageDisabled()
    {
        putenv('UPLOAD_PAGE_ENABLED=false');

        $middleware = new UploadPageEnabledMiddleware();
        $middleware->handle(new Request(), function() {

        });
    }


    /**
     * Tests that the middleware passes if UPLOAD_PAGE_ENABLED is true
     */
    public function testWithUploadPageEnabled()
    {
        putenv('UPLOAD_PAGE_ENABLED=true');

        $middleware = new UploadPageEnabledMiddleware();
        $this->assertMiddlewarePassed(new Request(), $middleware);
    }

}
