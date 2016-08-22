<?php namespace Gzero\Api;

use Illuminate\Routing\Router;
use League\Fractal\Manager;
use Gzero\Core\AbstractServiceProvider;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class ServiceProvider
 *
 * @package    Gzero
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class ServiceProvider extends AbstractServiceProvider {

    /**
     * List of additional providers
     *
     * @var array
     */
    protected $providers = [
        \Barryvdh\Cors\CorsServiceProvider::class,
        \Tymon\JWTAuth\Providers\JWTAuthServiceProvider::class
    ];

    /**
     * List of service providers aliases
     *
     * @var array
     */
    protected $aliases = [
        'JWTAuth'    => \Tymon\JWTAuth\Facades\JWTAuth::class,
        'JWTFactory' => \Tymon\JWTAuth\Facades\JWTFactory::class
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'admin.api.access' => \Gzero\Api\Middleware\AdminApiAccess::class,
        'jwt.auth'         => \Tymon\JWTAuth\Middleware\GetUserFromToken::class,
        'jwt.refresh'      => \Tymon\JWTAuth\Middleware\RefreshToken::class,
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
        $this->registerFilters();
        $this->bind();
    }

    /**
     * Bootstrap the application events.
     *
     * @param Router $router Laravel router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->registerRouteMiddleware($router);
        $this->registerRoutes();
    }

    /**
     * Add additional file to store routes
     *
     * @return void
     */
    protected function registerRoutes()
    {
        require __DIR__ . '/../../routes.php';
    }

    /**
     * Add additional file to store filters
     *
     * @return void
     */
    protected function registerFilters()
    {
        require __DIR__ . '/../../filters.php';
    }

    /**
     * Bind additional classes
     *
     * @return void
     */
    private function bind()
    {
        $this->app->bind(
            'League\Fractal\Manager',
            function () {
                $manager = new Manager();
                $manager->setSerializer(new ArraySerializer());
                return $manager;
            }
        );
    }

    /**
     * Register additional route middleware
     *
     * @param Router $router Laravel router
     *
     * @return void
     */
    private function registerRouteMiddleware(Router $router)
    {
        foreach ($this->routeMiddleware as $name => $class) {
            $router->middleware($name, $class);
        }
    }

}
