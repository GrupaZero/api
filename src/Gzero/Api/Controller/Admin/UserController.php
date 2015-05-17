<?php namespace Gzero\Api\Controller\Admin;

use Gzero\Api\Controller\ApiController;
use Gzero\Repository\UserRepository;
use Gzero\Api\Transformer\UserTransformer;
use Gzero\Api\UrlParamsProcessor;
use Gzero\Api\Validator\UserValidator;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class UserController
 *
 * @package    Gzero\Api\Controller\Admin
 * @author     Mateusz Urbanowicz <urbanowiczmateusz89@gmail.com>
 * @copyright  Copyright (c) 2015, Mateusz Urbanowicz
 */
class UserController extends ApiController {

    /**
     * @var UserRepository
     */
    protected $userRepo;

    /**
     * ContentController constructor.
     *
     * @param UrlParamsProcessor $processor Url processor
     * @param ContentRepository  $content   Content repository
     * @param ContentValidator   $validator Content validator
     */
    public function __construct(UrlParamsProcessor $processor, UserRepository $content, UserValidator $validator)
    {
        parent::__construct($processor);
        $this->validator = $validator->setData(\Input::all());
        $this->userRepo  = $content;
    }

    /**
     * Display list of users
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $input   = $this->validator->validate('list');
        $params  = $this->processor->process($input)->getProcessedFields();
        $results = $this->userRepo->getUsers(
            $params['filter'],
            $params['orderBy'],
            $params['page'],
            $params['perPage']
        );
        return $this->respondWithSuccess($results, new UserTransformer);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id user id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRepo->getById($id);
        if (empty($user)) {
            return $this->respondNotFound();
        } else {
            return $this->respondWithSuccess($user, new UserTransformer);
        }
    }

    /**
     * Remove the specified user from database.
     *
     * @param int $id Id of the user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = $this->userRepo->getById($id);

        if (!empty($user)) {
            $user->delete();
            return $this->respondWithSimpleSuccess(['success' => true]);
        }
        return $this->respondNotFound();
    }

    /**
     * Updates the specified resource in the database.
     *
     * @param int $id User id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        $user = $this->userRepo->getById($id);
        if (!empty($user)) {
            $input = $this->validator->validate('update');
            $user  = $this->userRepo->update($user, $input);
            return $this->respondWithSuccess($user, new UserTransformer());
        }
        return $this->respondNotFound();
    }


}
