<?php namespace Gzero\Api\Controllers;

use Gzero\Api\UrlParamsProcessor;
use Gzero\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Response;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class UserController
 *
 * @package    Gzero\Admin\Controllers\Resource
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class UserController extends ApiController {

    protected
        $userRepo,
        $processor;

    public function __construct(UserRepository $upload, UrlParamsProcessor $processor)
    {
        $this->userRepo  = $upload;
        $this->processor = $processor;
    }

    /**
     * Display a listing of the resource.
     *
     * @api           {get} /users Get users list
     * @apiVersion    0.1.0
     * @apiName       GetUserList
     * @apiGroup      User
     * @apiExample    Example usage:
     * curl -i http://localhost/api/v1/users
     * @apiSuccess {Array} data List of users (Array of Objects)
     * @apiPermission admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $page    = $this->processor->getPage();
        $orderBy = $this->processor->getOrderByParams();
        return Response::json(
            [
                'data'  => $this->userRepo->get($page, $orderBy)->toArray(),
                'total' => $this->userRepo->getLastTotal()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        return $this->userRepo->getById($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
} 
