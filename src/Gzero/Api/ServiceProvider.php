<?php namespace Gzero\Api;

use Gzero\Core\Exception;
use Gzero\Validator\ValidationException;
use Illuminate\Support\ServiceProvider as SP;
use League\Fractal\Manager;

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
        $this->app->error(
            function (Exception $exception) {
                // Api errors returned in json format
                if ($exception instanceof ValidationException) {
                    if (preg_match('/^api\./', \Request::getHost())) {
                        return \Response::json(
                            [
                                'code'     => 500,
                                'messages' => $exception->getErrors()
                            ],
                            500
                        );
                    }
                } else {
                    if (preg_match('/^api\./', \Request::getHost())) {
                        return \Response::json(
                            [
                                'code'    => $exception->getCode(),
                                'message' => $exception->getMessage()
                            ],
                            500
                        );
                    }
                }
            }
        );
    }

}
