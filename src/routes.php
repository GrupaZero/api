<?php

Route::group(
    array('prefix' => 'api/v1', 'before' => 'auth|admin'),
    function () {
        Route::resource('blocks', 'Gzero\Api\Controllers\BlockController');
        Route::resource('contents', 'Gzero\Api\Controllers\ContentController');
        Route::resource('contents.children', 'Gzero\Api\Controllers\ContentController', ['only' => ['index']]);
        Route::resource('contents.uploads', 'Gzero\Api\Controllers\UploadController');
        Route::resource('uploads', 'Gzero\Api\Controllers\UploadController');
        Route::resource('users', 'Gzero\Api\Controllers\UserController');
    }
);
