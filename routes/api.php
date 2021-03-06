<?php

// Admin API
use Gzero\Api\Middleware\AdminApiAccess;
use Barryvdh\Cors\HandleCors;

Route::group(
    [
        'domain'     => 'api.' . config('gzero.domain'),
        'prefix'     => 'v1/admin',
        'namespace'  => 'Gzero\Api\Controller\Admin',
        'middleware' => [HandleCors::class, 'auth:api', AdminApiAccess::class]
    ],
    function ($router) {
        /** @var \Illuminate\Routing\Router $router */

        // ======== Langs ========
        $router->resource(
            'langs',
            'LangController',
            ['only' => ['index', 'show']]
        );

        // ======== Blocks ========
        $router->get(
            'blocks/deleted',
            'BlockController@indexOfDeleted'
        );
        $router->get(
            'blocks/{id}/files',
            'BlockController@indexOfFiles'
        );
        $router->put(
            'blocks/{id}/files/sync',
            'BlockController@syncFiles'
        );
        $router->put(
            'blocks/restore/{id?}',
            'BlockController@restore'
        );
        $router->get(
            'blocks/content/{id}',
            'BlockController@indexForSpecificContent'
        );
        $router->resource(
            'blocks',
            'BlockController',
            ['only' => ['index', 'show', 'store', 'update', 'destroy']]
        );
        $router->resource(
            'blocks.translations',
            'BlockTranslationController',
            ['only' => ['index', 'show', 'store', 'update', 'destroy']]
        );

        // ======== Contents ========
        $router->get(
            'contents/tree/{id?}',
            'ContentController@indexTree'
        );
        $router->get(
            'contents/deleted',
            'ContentController@indexOfDeleted'
        );
        $router->get(
            'contents/{id}/files',
            'ContentController@indexOfFiles'
        );
        $router->put(
            'contents/{id}/files/sync',
            'ContentController@syncFiles'
        );
        $router->put(
            'contents/restore/{id?}',
            'ContentController@restore'
        );
        $router->delete(
            'contents/{id?}{?force=forceDelete?}',
            'ContentController@destroy'
        );
        $router->resource(
            'contents',
            'ContentController'
        );
        $router->resource(
            'contents.children',
            'ContentController',
            ['only' => ['index', 'show', 'update', 'destroy']]
        );
        $router->resource(
            'contents.translations',
            'ContentTranslationController',
            ['only' => ['index', 'show', 'store', 'update', 'destroy']]
        );
        $router->resource(
            'contents.route',
            'RouteController',
            ['only' => ['store']]
        );

        // ======== Files ========
        $router->resource(
            'files',
            'FileController',
            ['only' => ['index', 'show', 'store', 'update', 'destroy']]
        );
        $router->resource(
            'files.translations',
            'FileTranslationController',
            ['only' => ['index', 'show', 'store', 'update', 'destroy']]
        );

        // ======== Users ========
        $router->resource(
            'users',
            'UserController'
        );
        $router->resource(
            'options',
            'OptionController',
            ['only' => ['index', 'show', 'update']]
        );
    }
);

// Public API
Route::group(
    [
        'domain'     => 'api.' . config('gzero.domain'),
        'prefix'     => 'v1/user',
        'namespace'  => 'Gzero\Api\Controller\User',
        'middleware' => [HandleCors::class, 'auth:api']
    ],
    function ($router) {
        /** @var \Illuminate\Routing\Router $router */

        // ======== Account ========
        $router->put(
            'account',
            'AccountController@update'
        );

    }
);
