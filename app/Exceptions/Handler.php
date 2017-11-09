<?php

namespace Nord\ImageManipulationService\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use League\Flysystem\FileNotFoundException;
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
     * @inheritdoc
     */
    public function render($request, Exception $e)
    {
        // Change FileNotFoundException to NotFoundHttpException so we get the correct HTTP status code 
        if ($e instanceof FileNotFoundException) {
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

        return new JsonResponse($data);
    }

}
