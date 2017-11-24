<?php

namespace Nord\ImageManipulationService\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class Handler
 * @package Nord\ImageManipulationService\Exceptions
 */
class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * @var array exceptions that should be mapped to NotFoundHttpException
     */
    protected $notFoundExceptions = [
        \League\Flysystem\FileNotFoundException::class,
        \League\Glide\Filesystem\FileNotFoundException::class,
    ];

    /**
     * @inheritdoc
     */
    public function render($request, Exception $e)
    {
        // Change some exceptions to NotFoundHttpException so we get the correct HTTP status code
        if (in_array(get_class($e), $this->notFoundExceptions)) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }

        $data = [
            'exception' => get_class($e),
            'message'   => $e->getMessage(),
            'code'      => $e->getCode(),
        ];

        if (env('APP_DEBUG', false)) {
            $data['trace'] = $e->getTrace();
        }

        return new JsonResponse($data, $this->determineStatusCode($e));
    }

    /**
     * @param Exception $e
     *
     * @return int
     */
    private function determineStatusCode(\Exception $e): int
    {
        if ($e instanceof HttpException) {
            return $e->getStatusCode();
        }

        return 500;
    }

}
