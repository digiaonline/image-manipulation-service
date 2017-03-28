<?php

namespace Nord\ImageManipulationService\Http\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class DashboardEnabledMiddleware
 * @package Nord\ImageManipulationService\Http\Middleware
 */
class DashboardEnabledMiddleware
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
        $dashboardEnabled = env('DASHBOARD_ENABLED', false);

        if (!$dashboardEnabled) {
            throw new AccessDeniedHttpException();
        }

        return $next($request);
    }

}
