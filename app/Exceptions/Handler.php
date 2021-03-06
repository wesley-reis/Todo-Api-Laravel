<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            $apiErrorCode = 'NotFoundException';
            $message = 'Not found.';

            $exception = $e->getPrevious();

            if ($exception instanceof AuthorizationException) {
                return response()->json([
                    'error' => class_basename(AuthorizationException::class),
                    'message' => 'This action is unauthorized.'
                ], 403);
            }
            if ($exception instanceof ModelNotFoundException) {
                $modelName = class_basename($exception->getModel());
                $apiErrorCode = $modelName . $apiErrorCode;
                $message = $modelName . ' ' . $message;

            }


            return response()->json([
                'error'   => $apiErrorCode,
                'message' => $message,
            ], 404);
        });
    }


}
