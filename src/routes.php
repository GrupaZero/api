<?php

Route::group(
    ['before' => 'auth'],
    function () {
        // Admin API
        Route::group(
            ['domain' => 'api.' . Config::get('gzero.domain'), 'prefix' => 'v1/admin', 'before' => 'isActive'],
            function () {
                Route::resource('langs', 'Gzero\Api\Controller\Admin\LangController', ['only' => ['index', 'show']]);
                Route::resource('blocks', 'Gzero\Api\Controller\Admin\BlockController');
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
                Route::resource('contents.uploads', 'Gzero\Api\Controller\Admin\UploadController');
                Route::resource('uploads', 'Gzero\Api\Controller\Admin\UploadController');
            }
        );
    }
);
// Public API
Route::group(
    ['domain' => 'api.' . Config::get('gzero.domain'), 'prefix' => 'v1', 'before' => 'isActive'],
    function () {
        Route::resource('blocks', 'Gzero\Api\Controller\BlockController', ['only' => ['index', 'show']]);
        Route::resource('contents', 'Gzero\Api\Controller\ContentController', ['only' => ['index', 'show']]);
        Route::resource('contents.children', 'Gzero\Api\Controller\ContentController', ['only' => ['index']]);
    }
);
