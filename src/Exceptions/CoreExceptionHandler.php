<?php
/**
 * Created by rodrigobrun
 *   with PhpStorm
 */

namespace Newestapps\Core\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Newestapps\Core\Facades\Newestapps;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

abstract class CoreExceptionHandler extends ExceptionHandler
{

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Newestapps\Core\Http\Resources\ApiResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->wantsJson()) {
            if ($exception instanceof AuthorizationException) {
                return Newestapps::apiErrorResponse(null, $exception->getMessage(), 403)
                    ->response($request);
            }

            if ($exception instanceof AccessDeniedHttpException) {
                return Newestapps::apiErrorResponse($exception, $exception->getMessage(), $exception->getStatusCode())
                    ->response($request);
            }

            return Newestapps::apiErrorResponse($exception, $exception->getMessage(), 400)
                ->response($request);
        }

        return parent::render($request, $exception);
    }

}