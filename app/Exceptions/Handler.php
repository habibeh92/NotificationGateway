<?php

namespace App\Exceptions;

use App\Http\Responses\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Modules\Core\libraries\Exceptions\ApiException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }



    /**
     * Render an exception into an HTTP response.
     *
     * @param Request   $request
     * @param Throwable $exception
     *
     * @return JsonResponse|RedirectResponse|\Illuminate\Http\Response|Response
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        // check errors
        if ($exception instanceof NotFoundHttpException) {
            return $this->notFound($request, $exception);
        }

        if ($exception instanceof ModelNotFoundException) {
            return $this->modelNotFound($request, $exception);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof AuthorizationException) {
            return $this->unauthorized($request, $exception);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return $this->methodNotAllowed($request, $exception);
        }

        return parent::render($request, $exception);
    }



    /**
     * message of NotFoundHttpException
     *
     * @param Request               $request
     * @param NotFoundHttpException $exception
     *
     * @return \Illuminate\Http\Response|Response
     */
    public function notFound($request, NotFoundHttpException $exception)
    {
        return ApiResponse::clientError("not_found", [], 404);
    }



    /**
     * message of ModelNotFoundException
     *
     * @param Request                $request
     * @param ModelNotFoundException $exception
     *
     * @return \Illuminate\Http\Response|Response
     */
    public function modelNotFound($request, ModelNotFoundException $exception)
    {
        return ApiResponse::clientError("model_not_found", [], 404);
    }



    /**
     * Handle AuthenticationException
     *
     * @param Request                 $request
     * @param AuthenticationException $exception
     *
     * @return JsonResponse|RedirectResponse|Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return ApiResponse::clientError("unauthenticated", [], 401);
    }



    /**
     * Handle AuthorizationException
     *
     * @param Request                $request
     * @param AuthorizationException $exception
     *
     * @return JsonResponse|RedirectResponse|Response
     */
    protected function unauthorized($request, AuthorizationException $exception)
    {
        return ApiResponse::clientError("unauthorized", [], 403);
    }



    /**
     * Handle AuthorizationException
     *
     * @param Request                       $request
     * @param MethodNotAllowedHttpException $exception
     *
     * @return JsonResponse|RedirectResponse|Response
     */
    protected function methodNotAllowed($request, MethodNotAllowedHttpException $exception)
    {
        return ApiResponse::clientError("method_not_allowed", [], 405);
    }



    /**
     * customize validation error message
     *
     * @param Request             $request
     * @param ValidationException $exception
     *
     * @return JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return ApiResponse::clientError("validation_error", $exception->errors(), 422);
    }
}
