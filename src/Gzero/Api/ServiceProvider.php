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
        \Barryvdh\Cors\ServiceProvider::class,
    ];

    /**
     * List of service providers aliases
     *
     * @var array
     */
    protected $aliases = [];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'admin.api.access' => \Gzero\Api\Middleware\AdminApiAccess::class,
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
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
        $this->loadRoutesFrom(__DIR__.'/../../routes.php');
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
