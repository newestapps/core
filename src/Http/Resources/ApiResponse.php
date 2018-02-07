<?php

namespace Newestapps\Core\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Validation\Validator;

class ApiResponse extends Resource
{
    /**
     * @var int
     */
    private $statusCode;
    /**
     * @var null
     */
    private $message;

    /**
     * ApiResponse constructor.
     *
     * @param mixed $resource
     * @param null $message
     * @param int $statusCode
     */
    public function __construct($resource, $message = null, $statusCode = 200)
    {
        parent::__construct($resource);

        if ($resource instanceof Validator) {
            $this->statusCode = 400;
            $this->resource = $resource->messages();
            if (empty($message)) {
                $message = 'Falha ao processar sua solicitação';
            }
        } else {
            $this->statusCode = $statusCode;

            if (empty($message)) {
                $message = 'Sucesso';
            }
        }

        $this->message = $message;
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
            'success' => ($this->statusCode == 200 || $this->statusCode == 201),
            'message' => $this->message,
            'data' => parent::toArray($request),
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
