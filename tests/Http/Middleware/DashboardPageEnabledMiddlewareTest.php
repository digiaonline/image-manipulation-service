<?php

namespace Nord\ImageManipulationService\Tests\Http\Middleware;

use Nord\ImageManipulationService\Http\Middleware\DashboardPageEnabledMiddleware;
use Nord\ImageManipulationService\Tests\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DashboardPageEnabledMiddlewareTest
 * @package Nord\ImageManipulationService\Tests\Http\Middleware
 */
class DashboardPageEnabledMiddlewareTest extends TestCase
{

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    public function testWithDashboardPageDisabled()
    {
        putenv('DASHBOARD_PAGE_ENABLED=false');

        $middleware = new DashboardPageEnabledMiddleware();
        $middleware->handle(new Request(), function() {

        });
    }


    /**
     * Tests that the middleware passes if DASHBOARD_PAGE_ENABLED is true
     */
    public function testWithDashboardPageEnabled()
    {
        putenv('DASHBOARD_PAGE_ENABLED=true');

        $middleware = new DashboardPageEnabledMiddleware();
        $response   = $middleware->handle(new Request(), function() {
            return new Response();
        });

        $this->assertInstanceOf(Response::class, $response);
    }

}
