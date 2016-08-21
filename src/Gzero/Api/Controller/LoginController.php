<?php namespace Gzero\Api\Controller;

use Gzero\Validator\ValidationException;
use Illuminate\Support\MessageBag;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

/**
 * This file is part of the GZERO API package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class LoginController
 *
 * @package    Gzero\Admin\Controllers\Resource
 */
class LoginController extends ApiController {

    /**
     * @var JWTAuth
     */
    protected $JWTAuth;

    /**
     * LoginController constructor.
     *
     * @param JWTAuth $jwtAuth JWT Auth
     */
    public function __construct(JWTAuth $jwtAuth)
    {
        $this->JWTAuth = $jwtAuth;
    }

    /**
     * Login user
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function login()
    {
        $credentials = \Input::only('email', 'password');
        $token       = $this->JWTAuth->attempt($credentials);
        if (!$token) {
            throw new ValidationException(new MessageBag(['email' => 'invalid', 'password' => 'invalid']));
        }

        return response()->json(compact('token'));
    }

    /**
     * Logout user - it will add token to blacklist in redis.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function logout()
    {
        try {
            $this->JWTAuth->parseToken()->invalidate();
        } catch (JWTException $exception) {
            return $this->respondWithSimpleSuccess(['success' => false]);
        }
        return $this->respondWithSimpleSuccess(['success' => true]);
    }

}

/*
|--------------------------------------------------------------------------
| START API DOCS
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| END API DOCS
|--------------------------------------------------------------------------
*/
