<?php

group(
    ['middleware' => 'admin.api.access'],
    function () {
        // Admin API
        group(
            ['domain' => 'api.' . config('gzero.domain'), 'prefix' => 'v1/admin'],
            function () {
                // Langs
                resource('langs', 'Gzero\Api\Controller\Admin\LangController', ['only' => ['index', 'show']]);
                // Blocks
                get('blocks/deleted', ['uses' => 'Gzero\Api\Controller\Admin\BlockController@indexOfDeleted']);
                put('blocks/restore/{id?}', 'Gzero\Api\Controller\Admin\BlockController@restore');
                get('blocks/content/{id}', ['uses' => 'Gzero\Api\Controller\Admin\BlockController@indexForSpecificContent']);
                resource(
                    'blocks',
                    'Gzero\Api\Controller\Admin\BlockController',
                    ['only' => ['index', 'show', 'store', 'update', 'destroy']]
                );
                resource(
                    'blocks.translations',
                    'Gzero\Api\Controller\Admin\BlockTranslationController',
                    ['only' => ['index', 'show', 'store', 'update', 'destroy']]
                );
                // Contents
                get('contents/tree/{id?}', ['uses' => 'Gzero\Api\Controller\Admin\ContentController@indexTree']);
                get('contents/deleted', ['uses' => 'Gzero\Api\Controller\Admin\ContentController@indexOfDeleted']);
                put('contents/restore/{id?}', 'Gzero\Api\Controller\Admin\ContentController@restore');
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
                // Files
                resource(
                    'files',
                    'Gzero\Api\Controller\Admin\FileController',
                    ['only' => ['index', 'show', 'store', 'update', 'destroy']]
                );
                resource(
                    'files.translations',
                    'Gzero\Api\Controller\Admin\FileTranslationController',
                    ['only' => ['index', 'show', 'store', 'update', 'destroy']]
                );
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
