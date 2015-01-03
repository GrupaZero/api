<?php namespace Gzero\Api\Controller;

use Gzero\Api\UrlParamsProcessor;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Collection as EloquentCollection;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class BaseController
 *
 * @package    Gzero\Admin\Controllers\Resource
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class ApiController extends Controller {

    /**
     * @var UrlParamsProcessor
     */
    protected $processor;

    /**
     * @var Manager
     */
    protected $serializer;

    /**
     * ApiController constructor
     *
     * @param UrlParamsProcessor $processor Url processor
     */
    public function __construct(UrlParamsProcessor $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Return response in json format
     *
     * @param mixed $data    Response data
     * @param int   $code    Response code
     * @param array $headers HTTP headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond($data, $code, Array $headers = [])
    {
        return Response::json($data, $code, array_merge($this->defaultHeaders(), $headers));
    }

    /**
     * Return transformed response in json format
     *
     * @param mixed               $data        Response data
     * @param int                 $code        Response code
     * @param TransformerAbstract $transformer Transformer class
     * @param array               $headers     HTTP headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondTransformer($data, $code, TransformerAbstract $transformer, Array $headers = [])
    {
        if ($data instanceof Paginator) { // If we have paginated collection
            $resource = new Collection($data->getCollection(), $transformer);
            return $this->respond(
                [
                    'meta'   => [
                        'total'       => $data->getTotal(),
                        'perPage'     => $data->getPerPage(),
                        'currentPage' => $data->getCurrentPage(),
                        'lastPage'    => $data->getLastPage(),
                        'link'        => \URL::current()
                    ],
                    'params' => $this->processor->getProcessedFields(),
                    'data'   => $this->getSerializer()->createData($resource)->toArray()
                ],
                $code,
                $headers
            );
        } elseif ($data instanceof EloquentCollection) { // Collection without pagination
            $resource = new Collection($data, $transformer);
            return $this->respond(
                [
                    'data' => $this->getSerializer()->createData($resource)->toArray()
                ],
                $code,
                $headers
            );
        } else { // Single entity
            $resource = new Item($data, $transformer);
            return $this->respond(
                $this->getSerializer()->createData($resource)->toArray(),
                $code,
                $headers
            );
        }
    }

    /**
     * Return success response in json format
     *
     * @param mixed               $data        Response data
     * @param TransformerAbstract $transformer Transformer class
     * @param array               $headers     HTTP Header
     *
     * @return mixed
     */
    protected function respondWithSuccess($data, TransformerAbstract $transformer, Array $headers = [])
    {
        return $this->respondTransformer($data, SymfonyResponse::HTTP_ACCEPTED, $transformer, $headers);
    }

    /**
     * Return simple success response in json format
     *
     * @param mixed $data    Response data
     * @param array $headers HTTP Header
     *
     * @return mixed
     */
    protected function respondWithSimpleSuccess($data, Array $headers = [])
    {
        return $this->respond($data, SymfonyResponse::HTTP_ACCEPTED, $headers);
    }

    /**
     * Return server error response in json format
     *
     * @param string $message Custom error message
     * @param int    $code    Error code
     * @param array  $headers HTTP headers
     *
     * @return mixed
     */
    protected function respondWithError(
        $message = 'Internal Server Error!',
        $code = SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR,
        Array $headers = []
    ) {
        return $this->respond(
            [
                'error' => [
                    'code'    => 500,
                    'message' => $message
                ]
            ],
            $code,
            $headers
        );
    }

    /**
     * Return not found response in json format
     *
     * @param string $message Custom message
     * @param array  $headers HTTP headers
     *
     * @return mixed
     */
    protected function respondNotFound($message = 'Not found!', Array $headers = [])
    {
        return $this->respond(
            [
                'error' => [
                    'code'    => 404,
                    'message' => $message
                ]
            ],
            SymfonyResponse::HTTP_NOT_FOUND,
            $headers
        );
    }

    /**
     * Get serializer
     *
     * @return \League\Fractal\Manager
     */
    protected function getSerializer()
    {
        if (!isset($this->serializer)) {
            $this->serializer = \App::make('League\Fractal\Manager');
        }
        return $this->serializer;
    }

    /**
     * Default headers for api response
     *
     * @return array
     */
    protected function defaultHeaders()
    {
        return [];
    }
}

/**
 * @apiDefine admin Admin access rights needed.
 * These permissions is needed for access to all admin api methods
 */
/**
 * @apiDefine user User access rights needed.
 * Optionally you can write here further information about the permission.
 */

/**
 * @apiDefine Meta
 * @apiSuccess {Object[]} meta Meta data for current request
 * @apiSuccess {Integer} meta.total Total number elements
 * @apiSuccess {Integer} meta.perPage Number of elements per page
 * @apiSuccess {Integer} meta.currentPage Current page number
 * @apiSuccess {Integer} meta.lastPage Last page number
 * @apiSuccess {String} meta.link Link for this resource
 */

/**
 * @apiDefine Params
 * @apiSuccess {Object[]} params Params passed for current request
 * @apiSuccess {Integer} params.page Page parameter
 * @apiSuccess {Integer} params.perPage Per page parameter
 * @apiSuccess {Array[]} params.filter Array of filter params
 * @apiSuccess {Array[]} params.orderBy Array of sort params
 */
