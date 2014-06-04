<?php

Route::group(
    ['prefix' => 'admin/api/v1', 'before' => 'auth|admin'],
    function () {
        Route::resource('users', 'Gzero\Api\Admin\UserController');
    }
);

Route::group(
    ['prefix' => 'api/v1'],
    function () {
        Route::resource('blocks', 'Gzero\Api\Frontend\BlockController');
        Route::resource('contents', 'Gzero\Api\Frontend\ContentController');
        Route::resource('contents.children', 'Gzero\Api\Frontend\ContentController', ['only' => ['index']]);
        Route::resource('contents.uploads', 'Gzero\Api\Frontend\UploadController');
        Route::resource('uploads', 'Gzero\Api\Frontend\UploadController');

        Route::group(
            ['before' => 'auth'],
            function () {
                Route::resource('users', 'Gzero\Api\Controller\Frontend\UserController');
            }
        );
    }
);
