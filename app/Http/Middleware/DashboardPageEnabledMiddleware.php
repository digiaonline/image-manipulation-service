<?php

namespace Nord\ImageManipulationService\Http\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class DashboardPageEnabledMiddleware
 * @package Nord\ImageManipulationService\Http\Middleware
 */
class DashboardPageEnabledMiddleware
{

    /**
     * @param Request  $request
     * @param \Closure $next
     *
     * @throws AccessDeniedHttpException
     * @return Response
     */
    public function handle(Request $request, \Closure $next): Response
    {
        $dashboardPageEnabled = env('DASHBOARD_PAGE_ENABLED', false);

        if (!$dashboardPageEnabled) {
            throw new AccessDeniedHttpException();
        }

        return $next($request);
    }

}
