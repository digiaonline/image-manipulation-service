<?php

namespace Nord\ImageManipulationService\Tests\Http\Middleware;

use Nord\ImageManipulationService\Http\Middleware\UploadPageEnabledMiddleware;
use Nord\ImageManipulationService\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UploadPageEnabledMiddlewareTest
 * @package Nord\ImageManipulationService\Tests\Http\Middleware
 */
class UploadPageEnabledMiddlewareTest extends TestCase
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
        $response   = $middleware->handle(new Request(), function() {
            return new Response();
        });

        $this->assertInstanceOf(Response::class, $response);
    }

}
