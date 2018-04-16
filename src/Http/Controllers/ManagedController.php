<?php

namespace Newestapps\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Newestapps\Core\Facades\Newestapps;

class ManagedController extends Controller
{

    /**
     * @var Manager
     */
    private $manager;

    protected $transformer = null;

    /**
     * ManagedController constructor.
     */
    public function __construct()
    {
        if (request()->wantsJson()) {
            $this->manager = app(Manager::class);

            if (request()->has('include') && !empty(request()->get('include', null))) {
                $include = request()->get('include', null);
                $this->manager->parseIncludes($include);
            }
        }
    }

    public function itemResponse(
        Model $resource,
        $transformerClass = null,
        $message = 'OK',
        $status = 200,
        array $_links = []
    ) {
        if ($transformerClass === null) {
            $transformerClass = $this->transformer;
        }

        $response = new Item($resource, new $transformerClass);
        $response = $this->manager->createData($response)->toArray();

        return Newestapps::apiResponse($response, $message, $status, $_links);
    }

    public function collectionResponse(
        $resource,
        $transformerClass = null,
        $message = 'OK',
        $status = 200,
        array $_links = []
    ) {
        if ($transformerClass === null) {
            $transformerClass = $this->transformer;
        }

        $response = new Collection($resource, new $transformerClass);
        $response = $this->manager->createData($response)->toArray();

        return Newestapps::apiResponse($response, $message, $status, $_links);
    }

}