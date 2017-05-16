<?php

namespace Nord\ImageManipulationService\Tests\Http\Middleware;

use Illuminate\Http\Request;
use Nord\ImageManipulationService\Http\Middleware\ServeImageAuthenticationMiddleware;

/**
 * Class ServeImageAuthenticationMiddlewareTest
 * @package Nord\ImageManipulationService\Tests\Http\Middleware
 */
class ServeImageAuthenticationMiddlewareTest extends MiddlewareTestCase
{

    /**
     * Tests that the middleware passes when no custom headers have been specified
     */
    public function testNoRequiredCustomHeaders()
    {
        config([
            'app.required_custom_headers' => [],
        ]);

        $request    = new Request();
        $middleware = new ServeImageAuthenticationMiddleware();

        $this->assertMiddlewarePassed($request, $middleware);
    }

    /**
     * Tests that an exception is thrown if a required custom header is not present in the request
     *
     * @expectedException \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    public function testMissingRequiredCustomHeader()
    {
        config([
            'app.required_custom_headers' => [
                'name' => 'value',
            ],
        ]);

        $request    = new Request();
        $middleware = new ServeImageAuthenticationMiddleware();
        $middleware->handle($request, function () {

        });
    }

    /**
     * Tests that an exception if thrown if only one of several required custom headers is present
     *
     * @expectedException \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    public function testPartiallyMissingRequiredCustomHeaders()
    {
        config([
            'app.required_custom_headers' => [
                'first'  => 'value',
                'second' => 'othervalue',
            ],
        ]);

        $request = new Request();
        $request->headers->add([
            'first' => 'value',
        ]);

        $middleware = new ServeImageAuthenticationMiddleware();
        $middleware->handle($request, function () {

        });
    }

    /**
     * Tests that the middleware passes if all required custom headers are set
     */
    public function testNoMissingRequiredCustomHeaders()
    {
        $headers = [
            'first'  => 'value',
            'second' => 'othervalue',
        ];

        config(['app.required_custom_headers' => $headers]);

        $request = new Request();
        $request->headers->add($headers);

        $middleware = new ServeImageAuthenticationMiddleware();
        $this->assertMiddlewarePassed($request, $middleware);
    }

}
