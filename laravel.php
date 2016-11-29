<?php

require __DIR__ . '/vendor/autoload.php';

$Laravel = new class {
    use \Orchestra\Testbench\Traits\ApplicationTrait;

    protected function getPackageProviders($app)
    {
        $routes = $app['router']->getRoutes();

        // The URL generator needs the route collection that exists on the router.
        // Keep in mind this is an object, so we're passing by references here
        // and all the registered routes will be available to the generator.
        $app->instance('routes', $routes);

        // Register Exception handler
        $app->singleton(
            Illuminate\Contracts\Debug\ExceptionHandler::class,
            Gzero\Core\Exceptions\Handler::class
        );

        return [
            Gzero\Core\ServiceProvider::class,
            Gzero\Api\ServiceProvider::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set(
            'database.connections.testbench',
            [
                'driver'    => 'mysql',
                'host'      => 'localhost',
                'port'      => 3306,
                'database'  => 'gzero-tests',
                'username'  => 'root',
                'password'  => '',
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => '',
                'modes'     => [
                    'ONLY_FULL_GROUP_BY',
                    'STRICT_TRANS_TABLES',
                    'NO_ZERO_IN_DATE',
                    'NO_ZERO_DATE',
                    'ERROR_FOR_DIVISION_BY_ZERO',
                    'NO_AUTO_CREATE_USER',
                    'NO_ENGINE_SUBSTITUTION'
                ],
                'strict'    => true, // Not used when modes specified
                'engine'    => null,
            ]
        );

        //$this->beforeApplicationDestroyed(
        //    function () {
        //        \DB::disconnect('testbench');
        //    }
        //);
    }
};

$app = $Laravel->createApplication();

return $app;
