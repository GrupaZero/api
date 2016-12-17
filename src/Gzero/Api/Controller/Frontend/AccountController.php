<?php namespace Gzero\Api\Controller\Frontend;

use Gzero\Api\Controller\ApiController;
use Gzero\Entity\User;
use Gzero\Repository\UserRepository;
use Gzero\Api\Transformer\UserTransformer;
use Gzero\Api\UrlParamsProcessor;
use Gzero\Api\Validator\AccountValidator;
use Illuminate\Http\Request;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class AccountController
 */
class AccountController extends ApiController {

    /**
     * @var UserRepository
     */
    protected $userRepo;

    /**
     * UserController constructor.
     *
     * @param UrlParamsProcessor $processor Url processor
     * @param UserRepository     $content   User repository
     * @param AccountValidator   $validator User validator
     * @param Request            $request   Request object
     */
    public function __construct(
        UrlParamsProcessor $processor,
        UserRepository $content,
        AccountValidator $validator,
        Request $request
    ) {
        parent::__construct($processor);
        $this->validator = $validator->setData($request->all());
        $this->userRepo  = $content;
    }

    /**
     * Updates the specified resource in the database.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        if (!$request->has('password')) {
            $this->validator->setData($request->except(['password', 'password_confirmation']));
        }
        $user = $this->userRepo->getById($request->user()->id);
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
