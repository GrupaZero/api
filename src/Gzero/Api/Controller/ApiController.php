<?php namespace Gzero\Api\Controller;

use Gzero\Repository\LangRepository;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
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

    protected $langRepository;

    /**
     * ApiController constructor
     *
     * @param LangRepository $langRepository Lang repository
     */
    public function __construct(LangRepository $langRepository)
    {
        $this->langRepository = $langRepository;
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
        $serializer = App::make('JMS\Serializer\Serializer');
        return Response::make($serializer->serialize($data, 'json'), $code, array_merge($this->defaultHeaders(), $headers));
    }

    /**
     * Return success response in json format
     *
     * @param array $data    Response data
     * @param array $headers HTTP headers
     *
     * @return mixed
     */
    protected function respondWithSuccess($data, Array $headers = [])
    {
        return $this->respond($data, SymfonyResponse::HTTP_ACCEPTED, $headers);
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
     * Return not found response in json format
     *
     * @param string $message Custom message
     * @param array  $headers HTTP headers
     *
     * @return mixed
     */
    protected function respondWithInternalError($message = 'Internal Server Error!', Array $headers = [])
    {
        return $this->respond(
            [
                'error' => [
                    'code'    => 500,
                    'message' => $message
                ]
            ],
            SymfonyResponse::HTTP_INTERNAL_SERVER_ERROR,
            $headers
        );
    }

    /**
     * Return lang entity from current request
     *
     * @return mixed
     */
    protected function getRequestLang()
    {
        $lang = Input::get('lang');
        if ($lang) {
            return $this->langRepository->getByCode($lang);
        } else {
            return null;
        }
    }

    /**
     * Default headers for api response
     *
     * @return array
     */
    protected function defaultHeaders()
    {
        return [
            'Content-Type' => 'application/json'
        ];
    }
}
