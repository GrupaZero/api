<?php namespace Gzero\Api;

use Gzero\Repository\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\ServiceProvider as SP;
use JMS\Serializer\Context;
use JMS\Serializer\Handler\HandlerRegistry;
use JMS\Serializer\SerializerBuilder;
use League\Fractal\Manager;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\Serializer\JsonApiSerializer;

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
class ServiceProvider extends SP {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFilters();
        $this->registerApiErrorHandler();
        $this->bind();
        $this->registerDoctrineFilters();
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
        require_once __DIR__ . '/../../routes.php';
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
            'Gzero\Api\UrlParamsProcessor',
            function () {
                return new UrlParamsProcessor(Input::all());
            }
        );

        $this->app->bind(
            'League\Fractal\Manager',
            function () {
                $manager = new Manager();
                $manager->setSerializer(new JsonApiSerializer());
                return $manager;
            }
        );
    }

    /**
     * Register additional doctrine 2 filter
     *
     * @return void
     */
    public function registerDoctrineFilters()
    {
        $this->app['doctrine']->getConfiguration()->addFilter("isActive", 'Gzero\Api\IsActiveFilter');
    }

    /**
     * Register api error handler to return json on exceptions
     *
     * @return void
     */
    protected function registerApiErrorHandler()
    {
        $this->app->error(
            function ($exception) {
                // Api errors returned in json format
                if (preg_match('/^api\./', \Request::getHost())) {
                    return \Response::json(['error' => $exception->getMessage()], 500);
                }
            }
        );
    }

}
