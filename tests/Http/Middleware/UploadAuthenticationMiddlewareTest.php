<?php

namespace Nord\ImageManipulationService\Tests\Http\Middleware;

use Illuminate\Http\Request;
use Nord\ImageManipulationService\Http\Middleware\UploadAuthenticationMiddleware;

/**
 * Class UploadAuthenticationMiddlewareTest
 * @package Nord\ImageManipulationService\Tests\Http\Middleware
 */
class UploadAuthenticationMiddlewareTest extends MiddlewareTestCase
{

    /**
     * Tests that requests are allowed when upload authentication is disabled
     */
    public function testDisabledNoCredentials()
    {
        $this->configureEnvironment(false, '', '');

        $request = new Request();

        $middleware = new UploadAuthenticationMiddleware();
        $this->assertMiddlewarePassed($request, $middleware);
    }

    /**
     * Tests that requests are not allowed when upload authentication is enabled and no credentials have been
     * configured
     *
     * @expectedException \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    public function testEnabledNoCredentials()
    {
        $this->configureEnvironment(true, '', '');

        $request = new Request();

        $middleware = new UploadAuthenticationMiddleware();
        $this->assertMiddlewarePassed($request, $middleware);
    }

    /**
     * Tests that requests are not allowed when upload authentication is enabled and correct credentials have been
     * configured, but invalid credentials are passed in the request
     *
     * @expectedException \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    public function testEnabledWrongCredentials()
    {
        $this->configureEnvironment('true', 'correct', 'credentials');

        $request = new Request();
        $request->headers->set('PHP_AUTH_USER', 'wrong');
        $request->headers->set('PHP_AUTH_PW', 'creds');

        $middleware = new UploadAuthenticationMiddleware();
        $this->assertMiddlewarePassed($request, $middleware);
    }

    /**
     * Tests that requests are allowed when upload authentication is enabled and correct credentials have been
     * configured and passed in the request
     */
    public function testEnabledCorrectCredentials()
    {
        $this->configureEnvironment('true', 'correct', 'credentials');

        $request = new Request();
        $request->headers->set('PHP_AUTH_USER', 'correct');
        $request->headers->set('PHP_AUTH_PW', 'credentials');

        $middleware = new UploadAuthenticationMiddleware();
        $this->assertMiddlewarePassed($request, $middleware);
    }

    /**
     * Calls putenv() to configure the test case environment
     *
     * @param bool   $enabled
     * @param string $username
     * @param string $password
     */
    private function configureEnvironment(bool $enabled, string $username, string $password)
    {
        putenv('UPLOAD_AUTHENTICATION_ENABLED=' . ($enabled ? 'true' : 'false'));
        putenv('UPLOAD_USERNAME=' . $username);
        putenv('UPLOAD_PASSWORD=' . $password);
    }

}
