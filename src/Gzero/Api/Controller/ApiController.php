<?php namespace Gzero\Api\Controller;

use Gzero\Api\UrlParamsProcessor;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Collection as EloquentCollection;
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

    protected $transformer;

    protected $processor;

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
     * @apiDefinePermission admin Admin access rights needed.
     * These permissions allow you to view inactive contents
     */
    /**
     * @apiDefinePermission user User access rights needed.
     * Optionally you can write here further information about the permission.
     */

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
                        'link'        => \URL::full()
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
     * @param array|EloquentCollection $data        Response data
     * @param TransformerAbstract      $transformer Transformer class
     * @param array                    $headers     HTTP Header
     *
     * @return mixed
     */
    protected function respondWithSuccess($data, TransformerAbstract $transformer, Array $headers = [])
    {
        return $this->respondTransformer($data, SymfonyResponse::HTTP_ACCEPTED, $transformer, $headers);
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
        return \App::make('League\Fractal\Manager');
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
