<?php

Route::group(
    ['prefix' => 'api/v1'],
    function () {
        Route::resource('blocks', 'Gzero\Api\Controller\BlockController');
        Route::resource('contents', 'Gzero\Api\Controller\ContentController');
        Route::resource('contents.children', 'Gzero\Api\Controller\ContentController', ['only' => ['index']]);
        Route::resource('contents.uploads', 'Gzero\Api\Controller\UploadController');
        Route::resource('uploads', 'Gzero\Api\Controller\UploadController');
    }
);
