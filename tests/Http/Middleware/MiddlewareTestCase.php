<?php

namespace Nord\ImageManipulationService\Tests\Http\Middleware;

use Illuminate\Http\Request;
use Nord\ImageManipulationService\Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MiddlewareTestCase
 * @package Nord\ImageManipulationService\Tests\Http\Middleware
 */
abstract class MiddlewareTestCase extends TestCase
{

    /**
     * Asserts that the specified middleware passes with the specified request
     *
     * @param Request $request
     * @param mixed   $middleware
     */
    public function assertMiddlewarePassed(Request $request, $middleware)
    {
        $response = $middleware->handle($request, function () {
            return new Response();
        });

        $this->assertInstanceOf(Response::class, $response);
    }

}
