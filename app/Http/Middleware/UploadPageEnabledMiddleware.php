<?php

namespace Nord\ImageManipulationService\Http\Middleware;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class UploadPageEnabledMiddleware
 * @package Nord\ImageManipulationService\Http\Middleware
 */
class UploadPageEnabledMiddleware
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
        $uploadPageEnabled = env('UPLOAD_PAGE_ENABLED', false);

        if (!$uploadPageEnabled) {
            throw new AccessDeniedHttpException();
        }

        return $next($request);
    }

}
