<?php

namespace Newestapps\Core\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Validation\Validator;
use Prettus\Validator\Exceptions\ValidatorException;

class ApiErrorResponse extends ApiResponse
{

    /**
     * ApiResponse constructor.
     *
     * @param mixed $resource
     * @param null $message
     * @param int $statusCode
     */
    public function __construct($resource, $message = null, $statusCode = 400)
    {
        if ($resource === null) {
            $resource = collect(null);
        }

        parent::__construct($resource);

        if ($resource instanceof Validator) {
            $this->statusCode = 400;
            $this->resource = $resource->messages();
            if (empty($message)) {
                $message = 'Falha ao processar sua solicitação';
            }
        } elseif ($resource instanceof ValidatorException) {
            $this->statusCode = 400;
            $this->resource = $resource->getMessageBag();
            if (empty($message)) {
                $message = 'Falha ao processar sua solicitação';
            }
        } else {
            $this->resource = $resource;
            $this->statusCode = $statusCode;

            if (empty($message)) {
                $message = '';
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
            'message' => $this->message,
            'data' => [
                'errors' => $this->resource,
            ],
        ];
    }

}
