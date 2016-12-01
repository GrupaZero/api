<?php

namespace App;

use Barryvdh\Cors\HandlePreflight;
use Gzero\Api\ServiceProvider as AdminServiceProvider;
use Gzero\Core\ServiceProvider as CoreServiceProvider;
use Laravel\Passport\Passport;
use Laravel\Passport\PassportServiceProvider;

require_once __DIR__ . '/tests/fixture/User.php';
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
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            \Gzero\Core\Exceptions\Handler::class
        );

        // We need to tell Laravel Passport where to find oauth keys
        Passport::loadKeysFrom(__DIR__ . '/vendor/gzero/testing/oauth/');

        return [
            CoreServiceProvider::class,
            AdminServiceProvider::class,
            PassportServiceProvider::class
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
        // Use same key as it was used in platform
        $app['config']->set('app.key', '5IlQpknidVO1GleZITdWVWsUFdh1ozT7');
        // Use passport as guard for api
        $app['config']->set('auth.guards.api.driver', 'passport');

        // We need to add middleware to handle OPTIONS case
        app('Illuminate\Contracts\Http\Kernel')->prependMiddleware(HandlePreflight::class);
        // We want to return Access-Control-Allow-Credentials header as well
        $app['config']->set('cors.supportsCredentials', true);

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

    }
};

$app = $Laravel->createApplication();

return $app;
