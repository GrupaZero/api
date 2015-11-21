<?php

group(
    ['middleware' => 'auth'],
    function () {
        // Admin API
        group(
            ['domain' => 'api.' . config('gzero.domain'), 'prefix' => 'v1/admin'],
            function () {
                // Langs
                resource('langs', 'Gzero\Api\Controller\Admin\LangController', ['only' => ['index', 'show']]);
                // Blocks
                //resource('blocks', 'Gzero\Api\Controller\Admin\BlockController');
                // Contents
                get('contents/tree/{id?}', ['uses' => 'Gzero\Api\Controller\Admin\ContentController@indexTree']);
                get('contents/deleted', ['uses' => 'Gzero\Api\Controller\Admin\ContentController@indexOfDeleted']);
                put('contents/restore/{id?}', 'Gzero\Api\Controller\Admin\ContentController@restore');
                delete('contents/{id?}/{forceDelete?}', 'Gzero\Api\Controller\Admin\ContentController@destroy');
                resource('contents', 'Gzero\Api\Controller\Admin\ContentController');
                resource(
                    'contents.children',
                    'Gzero\Api\Controller\Admin\ContentController',
                    ['only' => ['index', 'show', 'update', 'destroy']]
                );
                resource(
                    'contents.translations',
                    'Gzero\Api\Controller\Admin\ContentTranslationController',
                    ['only' => ['index', 'show', 'store', 'update', 'destroy']]
                );
                resource(
                    'contents.route',
                    'Gzero\Api\Controller\Admin\RouteController',
                    ['only' => ['store']]
                );
                //resource('contents.uploads', 'Gzero\Api\Controller\Admin\UploadController');
                // Uploads
                //resource('uploads', 'Gzero\Api\Controller\Admin\UploadController');
                // Users
                resource('users', 'Gzero\Api\Controller\Admin\UserController');
                resource(
                    'options',
                    'Gzero\Api\Controller\Admin\OptionController',
                    ['only' => ['index', 'show', 'update']]
                );
            }
        );
    }
);
//// Public API
//group(
//    ['domain' => 'api.' . Config::get('gzero.domain'), 'prefix' => 'v1'],
//    function () {
//        resource('blocks', 'Gzero\Api\Controller\BlockController', ['only' => ['index', 'show']]);
//        resource('contents', 'Gzero\Api\Controller\ContentController', ['only' => ['index', 'show']]);
//        resource('contents.children', 'Gzero\Api\Controller\ContentController', ['only' => ['index']]);
//    }
//);
