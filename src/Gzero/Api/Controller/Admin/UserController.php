<?php namespace Gzero\Api\Controller\Admin;

use Gzero\Api\Controller\ApiController;
use Gzero\Entity\User;
use Gzero\Repository\UserRepository;
use Gzero\Api\Transformer\UserTransformer;
use Gzero\Api\UrlParamsProcessor;
use Gzero\Api\Validator\UserValidator;
use Illuminate\Http\Request;

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
     * UserController constructor.
     *
     * @param UrlParamsProcessor $processor Url processor
     * @param UserRepository     $content   User repository
     * @param UserValidator      $validator User validator
     * @param Request            $request   Request object
     */
    public function __construct(
        UrlParamsProcessor $processor,
        UserRepository $content,
        UserValidator $validator,
        Request $request
    ) {
        parent::__construct($processor);
        $this->validator = $validator->setData($request->all());
        $this->userRepo  = $content;
    }

    /**
     * Display list of users
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $this->authorize('readList', User::class);
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
        if (!empty($user)) {
            $this->authorize('read', $user);
            return $this->respondWithSuccess($user, new UserTransformer);
        }
        return $this->respondNotFound();
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
            $this->authorize('delete', $user);
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
            $this->authorize('update', $user);
            $input = $this->validator->bind('nick', ['user_id' => $user->id])->bind('email', ['user_id' => $user->id])
                ->validate('update');
            $user  = $this->userRepo->update($user, $input);
            return $this->respondWithSuccess($user, new UserTransformer());
        }
        return $this->respondNotFound();
    }


}
