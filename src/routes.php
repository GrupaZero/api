<?php

Route::group(
    ['middleware' => ['cors', 'admin.api.access']],
    function () {
        // Admin API
        Route::group(
            ['domain' => 'api.' . config('gzero.domain'), 'prefix' => 'v1/admin'],
            function () {
                // Langs
                Route::resource('langs', 'Gzero\Api\Controller\Admin\LangController', ['only' => ['index', 'show']]);
                // Blocks
                Route::get('blocks/deleted', ['uses' => 'Gzero\Api\Controller\Admin\BlockController@indexOfDeleted']);
                Route::put('blocks/restore/{id?}', 'Gzero\Api\Controller\Admin\BlockController@restore');
                Route::get(
                    'blocks/content/{id}',
                    ['uses' => 'Gzero\Api\Controller\Admin\BlockController@indexForSpecificContent']
                );
                Route::resource(
                    'blocks',
                    'Gzero\Api\Controller\Admin\BlockController',
                    ['only' => ['index', 'show', 'store', 'update', 'destroy']]
                );
                Route::resource(
                    'blocks.translations',
                    'Gzero\Api\Controller\Admin\BlockTranslationController',
                    ['only' => ['index', 'show', 'store', 'update', 'destroy']]
                );
                // Contents
                Route::get('contents/tree/{id?}', ['uses' => 'Gzero\Api\Controller\Admin\ContentController@indexTree']);
                Route::get('contents/deleted', ['uses' => 'Gzero\Api\Controller\Admin\ContentController@indexOfDeleted']);
                Route::put('contents/restore/{id?}', 'Gzero\Api\Controller\Admin\ContentController@restore');
                Route::delete('contents/{id?}{?force=forceDelete?}', 'Gzero\Api\Controller\Admin\ContentController@destroy');
                Route::resource('contents', 'Gzero\Api\Controller\Admin\ContentController');
                Route::resource(
                    'contents.children',
                    'Gzero\Api\Controller\Admin\ContentController',
                    ['only' => ['index', 'show', 'update', 'destroy']]
                );
                Route::resource(
                    'contents.translations',
                    'Gzero\Api\Controller\Admin\ContentTranslationController',
                    ['only' => ['index', 'show', 'store', 'update', 'destroy']]
                );
                Route::resource(
                    'contents.route',
                    'Gzero\Api\Controller\Admin\RouteController',
                    ['only' => ['store']]
                );
                // Files
                Route::resource(
                    'files',
                    'Gzero\Api\Controller\Admin\FileController',
                    ['only' => ['index', 'show', 'store', 'update', 'destroy']]
                );
                Route::resource(
                    'files.translations',
                    'Gzero\Api\Controller\Admin\FileTranslationController',
                    ['only' => ['index', 'show', 'store', 'update', 'destroy']]
                );
                // Users
                Route::resource('users', 'Gzero\Api\Controller\Admin\UserController');
                Route::resource(
                    'options',
                    'Gzero\Api\Controller\Admin\OptionController',
                    ['only' => ['index', 'show', 'update']]
                );
            }
        );
    }
);
// Public API
Route::group(
    ['domain' => 'api.' . Config::get('gzero.domain'), 'prefix' => 'v1', 'middleware' => ['cors']],
    function () {
        Route::post('login', ['as' => 'api.login', 'uses' => 'Gzero\Api\Controller\LoginController@login']);
        Route::post('logout', ['as' => 'api.logout', 'uses' => 'Gzero\Api\Controller\LoginController@logout']);
    }
);
