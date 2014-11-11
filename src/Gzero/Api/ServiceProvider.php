<?php namespace Gzero\Api;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\ServiceProvider as SP;
use JMS\Serializer\SerializerBuilder;

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

        // Registering JMS annotations
        AnnotationRegistry::registerAutoloadNamespace(
            'JMS\Serializer\Annotation',
            __DIR__ . '/../../../vendor/jms/serializer/src'
        );

        $this->app->singleton(
            'JMS\Serializer\Serializer',
            function () {
                return SerializerBuilder::create()
                    ->setCacheDir(storage_path())
                    ->setDebug(true)
                    ->build();
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

}
