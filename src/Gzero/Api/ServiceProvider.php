<?php namespace Gzero\Api;

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
        'Barryvdh\Cors\CorsServiceProvider'
    ];

    /**
     * List of service providers aliases
     *
     * @var array
     */
    protected $aliases = [];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register();
        $this->registerFilters();
        $this->registerApiErrorHandler();
        $this->bind();
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
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
     * Register api error handler to return json on exceptions
     *
     * @return void
     */
    protected function registerApiErrorHandler()
    {
        // TODO We need to think, if we want to register api error handler here
        //$this->app['Illuminate\Contracts\Debug\ExceptionHandler'];
    }

}
