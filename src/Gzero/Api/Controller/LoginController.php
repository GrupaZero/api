<?php namespace Gzero\Api\Controller;

use Gzero\Validator\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

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
     * Login user
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        //$token       = $this->JWTAuth->attempt($credentials);
        $token       = null;
        if (!$token) {
            throw new ValidationException(new MessageBag(['email' => 'invalid', 'password' => 'invalid']));
        }

        return response()->json([]);
    }

    /**
     * Logout user - it will add token to blacklist in redis.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function logout()
    {
        //try {
        //    $this->JWTAuth->parseToken()->invalidate();
        //} catch (JWTException $exception) {
        //    return $this->respondWithSimpleSuccess(['success' => false]);
        //}
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
