<?php

namespace Newestapps\Core\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Collection;
use Illuminate\Validation\Validator;

class ApiResponse extends Resource
{
    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var null
     */
    protected $message;

    /**
     * @var array
     */
    private $_links;

    /**
     * ApiResponse constructor.
     *
     * @param mixed $resource
     * @param null $message
     * @param int $statusCode
     * @param array $_links
     */
    public function __construct($resource, $message = null, $statusCode = 200, array $_links = [])
    {
        if ($resource === null) {
            $resource = collect(null);
        }

        parent::__construct($resource);
        $this->statusCode = $statusCode;

        if ($resource instanceof Validator) {
            $this->statusCode = 400;
            $this->resource = $resource->messages();
            if (empty($message)) {
                $message = 'Falha ao processar sua solicitação';
            }
        } elseif ($resource instanceof Collection || $resource instanceof \Illuminate\Database\Eloquent\Collection) {
            $this->resource = $resource->toArray();
        } elseif (is_array($resource)) {
            $this->resource = collect($resource);
        } elseif (is_object($resource) || $resource instanceof \stdClass) {
            $this->resource = collect($resource);
        }

        if (empty($message)) {
            $message = 'OK';
        }

        $this->message = $message;
        $this->_links = $_links;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray(
        $request
    ) {
        return [
            'message' => $this->message,
            'data' => parent::toArray($request),
            '_links' => array_merge([
                '_self' => $request->fullUrl(),
            ], $this->_links),
        ];
    }

    /**
     * Customize the outgoing response for the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\JsonResponse $response
     * @return void
     */
    public function withResponse(
        $request,
        $response
    ) {
        $response->header('X-NW-VERSION', app('X-NW-VERSION'));
        $response->setStatusCode($this->statusCode);
    }

}
