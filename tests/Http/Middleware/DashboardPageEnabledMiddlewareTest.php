<?php

namespace Nord\ImageManipulationService\Tests\Http\Middleware;

use Illuminate\Http\Request;
use Nord\ImageManipulationService\Http\Middleware\DashboardPageEnabledMiddleware;

/**
 * Class DashboardPageEnabledMiddlewareTest
 * @package Nord\ImageManipulationService\Tests\Http\Middleware
 */
class DashboardPageEnabledMiddlewareTest extends MiddlewareTestCase
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
        $this->assertMiddlewarePassed(new Request(), $middleware);
    }

}
