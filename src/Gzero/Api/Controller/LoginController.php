<?php namespace Gzero\Api\Controller;

use Gzero\Api\AccessForbiddenException;
use Gzero\Core\Controllers\BaseController;
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
class LoginController extends BaseController {

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
     * @throws AccessForbiddenException
     */
    public function index()
    {
        $credentials = \Input::only('email', 'password');
        $token       = $this->JWTAuth->attempt($credentials);
        if (!$token) {
            throw new AccessForbiddenException();
        }

        return response()->json(compact('token'));
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
