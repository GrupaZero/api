<?php namespace Gzero\Api\Middleware;

use Closure;
use Gzero\Api\AccessForbiddenException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\JWTAuth;

/**
 * This file is part of the GZERO Api package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class Access
 *
 * @package    Gzero\CORE
 */
class AdminApiAccess {

    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $auth;

    /**
     * Create a new BaseMiddleware instance.
     *
     * @param \Tymon\JWTAuth\JWTAuth $auth Auth
     */
    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Return 404 if user is not authenticated or got no admin rights
     *
     * @param \Illuminate\Http\Request $request Request object
     * @param \Closure                 $next    Next middleware
     *
     * @return mixed
     * @throws AccessForbiddenException
     */
    public function handle($request, Closure $next)
    {
        $token = $this->auth->setRequest($request)->getToken();
        if (!$token) {
            throw new AccessForbiddenException();
        }
        try {
            $user = $this->auth->authenticate($token);
            if ($user && ($user->hasPermission('admin-api-access') || $user->isSuperAdmin())) {
                return $next($request);
            }
        } catch (TokenExpiredException $e) {
            throw new AccessForbiddenException();
        } catch (JWTException $e) {
            throw new AccessForbiddenException();
        }
    }

}
