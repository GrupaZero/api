<?php

namespace App;

use Barryvdh\Cors\HandlePreflight;
use Gzero\Api\ServiceProvider as AdminServiceProvider;
use Gzero\Core\Middleware\Init;
use Gzero\Core\ServiceProvider as CoreServiceProvider;
use Laravel\Passport\Passport;
use Laravel\Passport\PassportServiceProvider;
use League\Flysystem\Adapter\NullAdapter;
use League\Flysystem\Filesystem;

require_once __DIR__ . '/tests/fixture/User.php';
require __DIR__ . '/vendor/autoload.php';

if (file_exists(__DIR__ . '/.env.testing')) {
    (new \Dotenv\Dotenv(__DIR__, '.env.testing'))->load();
}

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
        // Use null adapter for tests
        $app['filesystem']->extend(
            'nullAdapter',
            function ($app, $config) {
                return new Filesystem(new NullAdapter());
            }
        );

        // Use passport as guard for api
        $app['config']->set('auth.guards.api.driver', 'passport');

        // Set upload disk to local and change it's adapter to NullAdapter
        $app['config']->set('gzero.upload.disk', 'local');
        $app['config']->set('filesystems.disks.local.driver', 'nullAdapter');

        app('Illuminate\Contracts\Http\Kernel')->prependMiddleware(Init::class);
        // We want to return Access-Control-Allow-Credentials header as well
        $app['config']->set('cors.supportsCredentials', true);
        $app['config']->set(
            'database.connections.mysql.modes',
            [
                'ONLY_FULL_GROUP_BY',
                'STRICT_TRANS_TABLES',
                'NO_ZERO_IN_DATE',
                'NO_ZERO_DATE',
                'ERROR_FOR_DIVISION_BY_ZERO',
                'NO_AUTO_CREATE_USER',
                'NO_ENGINE_SUBSTITUTION'
            ]
        );
    }
};


$app = $Laravel->createApplication();

return $app;
