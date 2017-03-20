<?php namespace Gzero\Api\Controller;

use Gzero\Api\UrlParamsProcessor;
use Illuminate\Pagination\LengthAwarePaginator;
use Gzero\Core\Controllers\BaseController as Controller;
use Illuminate\Support\Collection as LaravelCollection;
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
 * Class ApiController
 *
 * @package Gzero\Admin\Controllers\Resource
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
    protected function respond($data, $code, array $headers = [])
    {
        return response()->json($data, $code, array_merge($this->defaultHeaders(), $headers));
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
    protected function respondTransformer($data, $code, TransformerAbstract $transformer, array $headers = [])
    {
        if ($data === null) { // If we have empty result
            return $this->respond(
                [
                    'data' => []
                ],
                $code,
                $headers
            );
        }

        if ($data instanceof LengthAwarePaginator) { // If we have paginated collection
            $resource = new Collection($data->items(), $transformer);
            return $this->respond(
                [
                    'meta'   => [
                        'total'       => $data->total(),
                        'perPage'     => $data->perPage(),
                        'currentPage' => $data->currentPage(),
                        'lastPage'    => $data->lastPage(),
                        'link'        => \URL::current()
                    ],
                    'params' => $this->processor->getProcessedFields(),
                    'data'   => $this->getSerializer()->createData($resource)->toArray()
                ],
                $code,
                $headers
            );
        } elseif ($data instanceof LaravelCollection) { // Collection without pagination
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
    protected function respondWithSuccess($data, TransformerAbstract $transformer, array $headers = [])
    {
        return $this->respondTransformer($data, SymfonyResponse::HTTP_OK, $transformer, $headers);
    }

    /**
     * Return simple success response in json format
     *
     * @param mixed $data    Response data
     * @param array $headers HTTP Header
     *
     * @return mixed
     */
    protected function respondWithSimpleSuccess($data, array $headers = [])
    {
        return $this->respond($data, SymfonyResponse::HTTP_OK, $headers);
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
        $message = 'Bad Request',
        $code = SymfonyResponse::HTTP_BAD_REQUEST,
        array $headers = []
    ) {
        return abort($code, $message, $headers);
    }

    /**
     * Return not found response in json format
     *
     * @param string $message Custom message
     * @param array  $headers HTTP headers
     *
     * @return mixed
     */
    protected function respondNotFound($message = 'Not found', array $headers = [])
    {
        return abort(404, $message, $headers);
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
