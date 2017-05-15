<?php

namespace Nord\ImageManipulationService\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Class UploadAuthenticationMiddleware
 * @package Nord\ImageManipulationService\Http\Middleware
 */
class UploadAuthenticationMiddleware
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
        // Skip if upload authentication is disabled
        if (env('UPLOAD_AUTHENTICATION_ENABLED', false)) {
            $username = env('UPLOAD_USERNAME');
            $password = env('UPLOAD_PASSWORD');

            // Protect against accidental misconfiguration
            if (!$this->credentialsMatch($username, $password, $request->getUser(), $request->getPassword())
            ) {
                throw new AccessDeniedHttpException();
            }
        }

        return $next($request);
    }

    /**
     * Returns whether the credentials are correct
     *
     * @param string|null $username
     * @param string|null $password
     * @param string|null $requestUsername
     * @param string|null $requestPassword
     *
     * @return bool
     */
    private function credentialsMatch($username, $password, $requestUsername, $requestPassword): bool
    {
        return $username !== null && $password !== null &&
            $requestUsername === $username && $requestPassword === $password;
    }

}
