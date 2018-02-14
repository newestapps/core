<?php
/**
 * Created by rodrigobrun
 *   with PhpStorm
 */

namespace Newestapps\Core\Facades;

use Illuminate\Support\Facades\Facade;
use Newestapps\Core\Http\Resources\ApiErrorResponse;
use Newestapps\Core\Http\Resources\ApiResponse;

/**
 * @method static ApiResponse apiResponse($resource, $message = null, $statusCode = 200, array $_links = [])
 * @method static ApiErrorResponse apiErrorResponse($resource, $message = null, $statusCode = 400)
 */
class Newestapps extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'nw-core';
    }

}