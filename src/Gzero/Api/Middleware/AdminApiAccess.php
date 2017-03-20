<?php namespace Gzero\Api\Middleware;

use Closure;

/**
 * This file is part of the GZERO Admin package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class AdminPanelAccess
 *
 * @package    Gzero\Admin
 */
class AdminApiAccess {

    /**
     * Return 404 if user is not authenticated or got no admin rights
     *
     * @param \Illuminate\Http\Request $request Request object
     * @param \Closure                 $next    Next middleware
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->hasPermission('admin-api-access') || $request->user()->isSuperAdmin()) {
            return $next($request);
        }
        return abort(404);
    }
}
