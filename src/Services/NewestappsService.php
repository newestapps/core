<?php
/**
 * Created by rodrigobrun
 *   with PhpStorm
 */

namespace Newestapps\Core\Services;

use Illuminate\Http\Request;
use Newestapps\Core\Http\Resources\ApiErrorResponse;
use Newestapps\Core\Http\Resources\ApiResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class NewestappsService
{

    public function apiResponse($resource, $message = null, $statusCode = 200, array $_links = [])
    {
        return new ApiResponse($resource, $message, $statusCode, $_links);
    }

    public function apiErrorResponse($resource, $message = null, $statusCode = 400)
    {
        return new ApiErrorResponse($resource, $message, $statusCode);
    }

}