<?php

Route::group(
    ['before' => 'auth'],
    function () {
        // Admin API
        Route::group(
            ['domain' => 'api.' . Config::get('gzero.domain'), 'prefix' => 'v1/admin'],
            function () {
                // Langs
                Route::resource('langs', 'Gzero\Api\Controller\Admin\LangController', ['only' => ['index', 'show']]);
                // Blocks
                //Route::resource('blocks', 'Gzero\Api\Controller\Admin\BlockController');
                // Contents
                Route::get('contents/tree/{id?}', ['uses' => 'Gzero\Api\Controller\Admin\ContentController@indexTree']);
                Route::get('contents/deleted', ['uses' => 'Gzero\Api\Controller\Admin\ContentController@indexOfDeleted']);
                Route::put('contents/restore/{id?}', 'Gzero\Api\Controller\Admin\ContentController@restore');
                Route::delete('contents/{id?}/{forceDelete?}', 'Gzero\Api\Controller\Admin\ContentController@destroy');
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
                //Route::resource('contents.uploads', 'Gzero\Api\Controller\Admin\UploadController');
                // Uploads
                //Route::resource('uploads', 'Gzero\Api\Controller\Admin\UploadController');
                // Users
                Route::resource('users', 'Gzero\Api\Controller\Admin\UserController');
            }
        );
    }
);
//// Public API
//Route::group(
//    ['domain' => 'api.' . Config::get('gzero.domain'), 'prefix' => 'v1'],
//    function () {
//        Route::resource('blocks', 'Gzero\Api\Controller\BlockController', ['only' => ['index', 'show']]);
//        Route::resource('contents', 'Gzero\Api\Controller\ContentController', ['only' => ['index', 'show']]);
//        Route::resource('contents.children', 'Gzero\Api\Controller\ContentController', ['only' => ['index']]);
//    }
//);
