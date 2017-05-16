<?php

namespace Nord\ImageManipulationService\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class ServeImageAuthenticationMiddleware
 * @package Nord\ImageManipulationService\Http\Middleware
 */
class ServeImageAuthenticationMiddleware
{

    /**
     * @param Request  $request
     * @param \Closure $next
     *
     * @return Response
     *
     * @throws AccessDeniedHttpException
     */
    public function handle(Request $request, \Closure $next): Response
    {
        $requiredCustomHeaders = config('app.required_custom_headers', []);

        foreach ($requiredCustomHeaders as $name => $value) {
            if (!$request->hasHeader($name) || $request->header($name) !== $value) {
                throw new AccessDeniedHttpException();
            }
        }

        return $next($request);
    }

}
