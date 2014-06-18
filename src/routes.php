<?php

Route::group(
    setMultilangRouting(),
    function () {
        Route::group(
            ['before' => 'auth'],
            function () {
                // Admin API
                Route::group(
                    ['prefix' => 'api/v1'],
                    function () {
                        Route::resource('blocks', 'Gzero\Api\Controller\Admin\BlockController');
                        Route::resource('contents', 'Gzero\Api\Controller\Admin\ContentController');
                        Route::resource(
                            'contents.children',
                            'Gzero\Api\Controller\Admin\ContentController',
                            ['only' => ['index']]
                        );
                        Route::resource('contents.uploads', 'Gzero\Api\Controller\Admin\UploadController');
                        Route::resource('uploads', 'Gzero\Api\Controller\Admin\UploadController');
                    }
                );
            }
        );
        // Public API
        Route::group(
            ['prefix' => 'api/v1'],
            function () {
                /* @TODO */
            }
        );
    }
);
