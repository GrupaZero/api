<?php
namespace api;

class AdminBlockCest {
    /**
     * @var string endpoint url
     */
    protected $url = 'http://api.localhost/v1/admin/blocks';

    public function _before(FunctionalTester $I)
    {
        $I->logout();
    }

    public function _after(FunctionalTester $I)
    {
    }

    /*
     |--------------------------------------------------------------------------
     | START Block list tests
     |--------------------------------------------------------------------------
     */

    public function getBlocks(FunctionalTester $I)
    {
        $I->wantTo('get list of blocks as admin user');
        $I->loginAsAdmin();
        $user         = $I->haveUser();
        $blocksNumber = 4;
        for ($i = 0; $i < $blocksNumber; $i++) {
            $I->haveBlock(false, $user);
        }
        $I->sendGET($this->url);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'meta'   => [
                    'total'       => $blocksNumber,
                    'perPage'     => 20,
                    'currentPage' => 1,
                    'lastPage'    => 1,
                    'link'        => $this->url,
                ],
                'params' => [
                    'page'    => 1,
                    'perPage' => 20,
                    'filter'  => [],
                ],
            ]
        );
    }

    public function getDeletedBlocks(FunctionalTester $I)
    {
        $I->wantTo('get list of soft deleted blocks as admin user');
        $I->loginAsAdmin();
        $user  = $I->haveUser();
        $block = $I->haveBlock(
            [
                'type'         => 'basic',
                'region'       => 'header',
                'weight'       => 1,
                'filter'       => ['+' => ['1/2/3']],
                'options'      => ['option' => 'value'],
                'isActive'     => true,
                'isCacheable'  => true,
                'translations' => [
                    'langCode' => 'en',
                    'title'    => 'Example block title',
                    'body'     => 'Example block body'
                ]
            ],
            $user
        );
        $I->sendDelete($this->url . '/' . $block->id);
        $I->sendGET($this->url . '/deleted');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'meta'   => [
                    'total'       => 1,
                    'perPage'     => 20,
                    'currentPage' => 1,
                    'lastPage'    => 1,
                    'link'        => $this->url . '/deleted',
                ],
                'params' => [
                    'page'    => 1,
                    'perPage' => 20,
                    'filter'  => [],
                ],
            ]
        );
    }

    public function getSingleBlock(FunctionalTester $I)
    {
        $I->wantTo('get single block as admin user');
        $I->loginAsAdmin();
        $user  = $I->haveUser();
        $block = $I->haveBlock(
            [
                'type'         => 'basic',
                'region'       => 'header',
                'weight'       => 1,
                'filter'       => ['+' => ['1/2/3']],
                'options'      => ['option' => 'value'],
                'isActive'     => true,
                'isCacheable'  => true,
                'translations' => [
                    'langCode' => 'en',
                    'title'    => 'Example block title',
                    'body'     => 'Example block body'
                ]
            ],
            $user
        );
        $I->sendGet(
            $this->url . '/' . $block->id
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'type'         => 'basic',
                'region'       => 'header',
                'weight'       => 1,
                'filter'       => ['+' => ['1/2/3']],
                'options'      => ['option' => 'value'],
                'isActive'     => true,
                'isCacheable'  => true,
                'translations' =>
                    [
                        0 =>
                            [
                                'langCode' => 'en',
                                'title'    => 'Example block title',
                                'body'     => 'Example block body'
                            ],
                    ],
            ]
        );
    }

    public function checksIfBlockExistsWhenGetting(FunctionalTester $I)
    {
        $I->wantTo('checks for block when getting block as admin user');
        $I->loginAsAdmin();
        $I->sendPUT($this->url . '/1');
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'code'    => 404,
                'message' => "Not found",
            ]
        );
    }

    /*
     |--------------------------------------------------------------------------
     | END Block list tests
     |--------------------------------------------------------------------------
     */

    /*
     |--------------------------------------------------------------------------
     | START Block for content tests
     |--------------------------------------------------------------------------
     */

    public function getContentBlocks(FunctionalTester $I)
    {
        $I->wantTo('get list of blocks for specific content as admin user');
        $I->loginAsAdmin();
        $category       = $I->haveContent(['type' => 'category']);
        $nestedCategory = $I->haveContent(['type' => 'category', 'parentId' => $category->id]);
        $content        = $I->haveContent(['type' => 'content', 'parentId' => $nestedCategory->id]);
        // Block for this content
        $I->sendPOST(
            $this->url,
            [
                'type'         => 'basic',
                'region'       => 'header',
                'weight'       => 1,
                'filter'       => ['+' => [$content->path]],
                'options'      => ['option' => 'value'],
                'isActive'     => true,
                'isCacheable'  => true,
                'translations' => [
                    'langCode' => 'en',
                    'title'    => 'First block title',
                    'body'     => 'First block body'
                ]
            ]
        );
        // Block for this content parent children's
        $I->sendPOST(
            $this->url,
            [
                'type'         => 'basic',
                'region'       => 'sidebar',
                'weight'       => 2,
                'filter'       => ['+' => [$nestedCategory->path . '*']],
                'options'      => ['option' => 'value'],
                'isActive'     => true,
                'isCacheable'  => true,
                'translations' => [
                    'langCode' => 'en',
                    'title'    => 'Second block title',
                    'body'     => 'Second block body'
                ]
            ]
        );
        // Block for this content root parent children's
        $I->sendPOST(
            $this->url,
            [
                'type'         => 'basic',
                'region'       => 'footer',
                'weight'       => 3,
                'filter'       => ['+' => [$category->path . '*']],
                'options'      => ['option' => 'value'],
                'isActive'     => true,
                'isCacheable'  => true,
                'translations' => [
                    'langCode' => 'en',
                    'title'    => 'Third block title',
                    'body'     => 'Third block body'
                ]
            ]
        );
        // Block hidden on this content
        $I->sendPOST(
            $this->url,
            [
                'type'         => 'basic',
                'filter'       => ['-' => [$content->path]],
                'isActive'     => true,
                'translations' => [
                    'langCode' => 'en',
                    'title'    => 'Content hidden block title',
                    'body'     => 'Content hidden block body'
                ]
            ]
        );
        // Block shown and hidden on this content, should remain hidden
        $I->sendPOST(
            $this->url,
            [
                'type'         => 'basic',
                'filter'       => ['+' => [$content->path], '-' => [$content->path]],
                'isActive'     => true,
                'translations' => [
                    'langCode' => 'en',
                    'title'    => 'Content shown and hidden block title',
                    'body'     => 'Content shown and hidden block body'
                ]

            ]
        );
        // Block hidden on this content parent children's
        $I->sendPOST(
            $this->url,
            [
                'type'         => 'basic',
                'filter'       => ['-' => [$nestedCategory->path . '*']],
                'isActive'     => true,
                'translations' => [
                    'langCode' => 'en',
                    'title'    => 'Content parent hidden block title',
                    'body'     => 'Content parent hidden block body'
                ]
            ]
        );
        // Block hidden on this content root parent children's
        $I->sendPOST(
            $this->url,
            [
                'type'         => 'basic',
                'filter'       => ['-' => [$category->path . '*']],
                'isActive'     => true,
                'translations' => [
                    'langCode' => 'en',
                    'title'    => 'Content root parent hidden block title',
                    'body'     => 'Content root parent hidden block body'
                ]
            ]
        );
        $I->sendGET($this->url . '/content/' . $content->id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(
            [
                'data' => [
                    0 => [
                        'type'         => 'basic',
                        'region'       => 'header',
                        'filter'       => ['+' => [$content->path]],
                        'options'      => ['option' => 'value'],
                        'weight'       => 1,
                        'isActive'     => true,
                        'isCacheable'  => true,
                        'translations' =>
                            [
                                0 =>
                                    [
                                        'langCode' => 'en',
                                        'title'    => 'First block title',
                                        'body'     => 'First block body',
                                    ],
                            ],
                    ],
                    1 => [
                        'type'         => 'basic',
                        'region'       => 'sidebar',
                        'filter'       => ['+' => [$nestedCategory->path . '*']],
                        'options'      => ['option' => 'value'],
                        'weight'       => 2,
                        'isActive'     => true,
                        'isCacheable'  => true,
                        'translations' =>
                            [
                                0 =>
                                    [
                                        'langCode' => 'en',
                                        'title'    => 'Second block title',
                                        'body'     => 'Second block body',
                                    ],
                            ],
                    ],
                    2 => [
                        'type'         => 'basic',
                        'region'       => 'footer',
                        'filter'       => ['+' => [$category->path . '*']],
                        'options'      => ['option' => 'value'],
                        'weight'       => 3,
                        'isActive'     => true,
                        'isCacheable'  => true,
                        'translations' =>
                            [
                                0 =>
                                    [
                                        'langCode' => 'en',
                                        'title'    => 'Third block title',
                                        'body'     => 'Third block body',
                                    ],
                            ],
                    ]
                ],

            ]

        );
        // Block hidden on this content
        $I->dontSeeResponseContainsJson(
            [
                'type'         => 'basic',
                'filter'       => ['-' => ['1/2/3/']],
                'translations' =>
                    [
                        0 =>
                            [
                                'langCode' => 'en',
                                'title'    => 'Content hidden block title',
                                'body'     => 'Content hidden block body'
                            ],
                    ],
            ]
        );
        // Block shown and hidden on this content, should remain hidden
        $I->dontSeeResponseContainsJson(
            [
                'type'         => 'basic',
                'filter'       => ['+' => ['1/2/3/'], '-' => ['1/2/3/']],
                'translations' =>
                    [
                        0 =>
                            [
                                'langCode' => 'en',
                                'title'    => 'Content shown and hidden block title',
                                'body'     => 'Content shown and hidden block body'
                            ],
                    ],
            ]
        );
        // Block hidden on this content parent children's
        $I->dontSeeResponseContainsJson(
            [
                'type'         => 'basic',
                'filter'       => ['-' => ['1/2/*']],
                'translations' =>
                    [
                        0 =>
                            [
                                'langCode' => 'en',
                                'title'    => 'Content parent hidden block title',
                                'body'     => 'Content parent hidden block body'
                            ],
                    ],
            ]
        );
        // Block hidden on this content root parent children's
        $I->dontSeeResponseContainsJson(
            [
                'type'         => 'basic',
                'filter'       => ['-' => ['1/*']],
                'translations' =>
                    [
                        0 =>
                            [
                                'langCode' => 'en',
                                'title'    => 'Content root parent hidden block title',
                                'body'     => 'Content root parent hidden block body'
                            ],
                    ],
            ]
        );
    }

    public function checksIfBlockExistsWhenGettingForContent(FunctionalTester $I)
    {
        $I->wantTo('checks for block when getting block for content as admin user');
        $I->loginAsAdmin();
        $I->sendGET($this->url . '/content/1');
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'code'    => 404,
                'message' => "Not found",
            ]
        );
    }

    /*
     |--------------------------------------------------------------------------
     | END Block for content tests
     |--------------------------------------------------------------------------
     */

    /*
     |--------------------------------------------------------------------------
     | START Block tests
     |--------------------------------------------------------------------------
     */

    public function createBlock(FunctionalTester $I)
    {
        $I->wantTo('create block as admin user');
        $I->loginAsAdmin();
        $I->sendPOST(
            $this->url,
            [
                'type'         => 'basic',
                'region'       => 'header',
                'weight'       => 1,
                'filter'       => ['+' => ['1/2/3']],
                'options'      => ['option' => 'value'],
                'isActive'     => true,
                'isCacheable'  => true,
                'translations' => [
                    'langCode' => 'en',
                    'title'    => 'Example block title',
                    'body'     => 'Example block body'
                ]
            ]
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'type'         => 'basic',
                'region'       => 'header',
                'filter'       => ['+' => ['1/2/3']],
                'options'      => ['option' => 'value'],
                'weight'       => 1,
                'isActive'     => true,
                'isCacheable'  => true,
                'translations' =>
                    [
                        0 =>
                            [
                                'langCode' => 'en',
                                'title'    => 'Example block title',
                                'body'     => 'Example block body',
                            ],
                    ],
            ]

        );
    }

    public function createWidgetBlock(FunctionalTester $I)
    {
        $I->wantTo('create widget block as admin user');
        $I->loginAsAdmin();
        $I->sendPOST(
            $this->url,
            [
                'type'         => 'widget',
                'region'       => 'header',
                'weight'       => 1,
                'filter'       => ['+' => ['1/2/3']],
                'options'      => ['option' => 'value'],
                'widget'       => [
                    'name'        => 'getLastContent',
                    'args'        => ['contentId' => 1],
                    'isActive'    => 1,
                    'isCacheable' => 1,
                ],
                'isActive'     => true,
                'isCacheable'  => true,
                'translations' => [
                    'langCode' => 'en',
                    'title'    => 'Example block title',
                    'body'     => 'Example block body'
                ]
            ]
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'type'         => 'widget',
                'region'       => 'header',
                'filter'       => ['+' => ['1/2/3']],
                'options'      => ['option' => 'value'],
                'blockabale'   => [
                    'name'        => 'getLastContent',
                    'args'        => ['contentId' => 1],
                    'isActive'    => 1,
                    'isCacheable' => 1,
                ],
                'weight'       => 1,
                'isActive'     => true,
                'isCacheable'  => true,
                'translations' =>
                    [
                        0 => [
                            'langCode' => 'en',
                            'title'    => 'Example block title',
                            'body'     => 'Example block body',
                        ],
                    ],
            ]
        );
    }

    public function UpdateBlock(FunctionalTester $I)
    {
        $I->wantTo('update block as admin user');
        $I->loginAsAdmin();
        $user  = $I->haveUser();
        $block = $I->haveBlock(
            [
                'type'         => 'basic',
                'region'       => 'header',
                'weight'       => 1,
                'filter'       => ['+' => ['1/2/3']],
                'options'      => ['option' => 'value'],
                'isActive'     => true,
                'isCacheable'  => true,
                'translations' => [
                    'langCode' => 'en',
                    'title'    => 'Example block title',
                    'body'     => 'Example block body'
                ]
            ],
            $user
        );
        $I->sendPUT(
            $this->url . '/' . $block->id,
            [
                'type'        => 'menu',
                'region'      => 'footer',
                'weight'      => 5,
                'filter'      => ['+' => ['1/2/5']],
                'options'     => ['option' => 'new value'],
                'isActive'    => false,
                'isCacheable' => false
            ]
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'region'      => 'footer',
                'weight'      => 5,
                'filter'      => ['+' => ['1/2/5']],
                'options'     => ['option' => 'new value'],
                'isActive'    => false,
                'isCacheable' => false
            ]
        );
    }

    public function checksIfBlockExistsWhenUpdating(FunctionalTester $I)
    {
        $I->wantTo('checks for block when updating block as admin user');
        $I->loginAsAdmin();
        $I->sendPUT($this->url . '/1');
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'code'    => 404,
                'message' => "Not found",
            ]
        );
    }

    public function DeleteBlock(FunctionalTester $I)
    {
        $I->wantTo('delete block as admin user');
        $I->loginAsAdmin();
        $user  = $I->haveUser();
        $block = $I->haveBlock(
            [
                'type'         => 'basic',
                'region'       => 'header',
                'weight'       => 1,
                'filter'       => ['+' => ['1/2/3']],
                'options'      => ['option' => 'value'],
                'isActive'     => true,
                'isCacheable'  => true,
                'translations' => [
                    'langCode' => 'en',
                    'title'    => 'Example block title',
                    'body'     => 'Example block body'
                ]
            ],
            $user
        );
        $I->sendDelete($this->url . '/' . $block->id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'success' => true,
            ]
        );
    }

    public function ForceDeleteBlock(FunctionalTester $I)
    {
        $I->wantTo('force delete block as admin user');
        $I->loginAsAdmin();
        $user  = $I->haveUser();
        $block = $I->haveBlock(
            [
                'type'         => 'basic',
                'region'       => 'header',
                'weight'       => 1,
                'filter'       => ['+' => ['1/2/3']],
                'options'      => ['option' => 'value'],
                'isActive'     => true,
                'isCacheable'  => true,
                'translations' => [
                    'langCode' => 'en',
                    'title'    => 'Example block title',
                    'body'     => 'Example block body'
                ]
            ],
            $user
        );
        $I->sendDelete($this->url . '/' . $block->id);
        $I->sendDelete($this->url . '/' . $block->id, ['force' => true]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'success' => true,
            ]
        );
    }

    public function RestoreDeletedBlock(FunctionalTester $I)
    {
        $I->wantTo('restore deleted block as admin user');
        $I->loginAsAdmin();
        $user  = $I->haveUser();
        $block = $I->haveBlock(
            [
                'type'         => 'basic',
                'region'       => 'header',
                'weight'       => 1,
                'filter'       => ['+' => ['1/2/3']],
                'options'      => ['option' => 'value'],
                'isActive'     => true,
                'isCacheable'  => true,
                'translations' => [
                    'langCode' => 'en',
                    'title'    => 'Example block title',
                    'body'     => 'Example block body'
                ]
            ],
            $user
        );
        $I->sendDelete($this->url . '/' . $block->id);
        $I->sendPut($this->url . '/restore/' . $block->id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'success' => true,
            ]
        );
    }

    public function checksIfBlockExistsWhenDeleting(FunctionalTester $I)
    {
        $I->wantTo('check for block when force delete block as admin user');
        $I->loginAsAdmin();
        $I->sendDelete($this->url . '/1');
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'code'    => 404,
                'message' => "Not found",
            ]
        );
    }

    public function checksIfBlockExistsWhenRestoring(FunctionalTester $I)
    {
        $I->wantTo('check for block when restoring block as admin user');
        $I->loginAsAdmin();
        $I->sendPut($this->url . '/restore/1');
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'code'    => 404,
                'message' => "Not found",
            ]
        );
    }

    public function checksWidgetFieldWhenCreatingWidgetBlock(FunctionalTester $I)
    {
        $I->wantTo('check for widget field when creating block as admin user');
        $I->loginAsAdmin();
        $I->sendPOST(
            $this->url,
            [
                'type'         => 'faketype',
                'translations' => [
                    'langCode' => 'en',
                    'title'    => 'Example block title',
                    'body'     => 'Example block body'
                ]
            ]
        );
        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'code'    => 400,
                'message' => 'Validation Error',
                'errors'  =>
                    [
                        'type' =>
                            [
                                0 => 'The selected type is invalid.',
                            ],
                    ],
            ]
        );
    }

    public function checksTypeWhenCreatingBlock(FunctionalTester $I)
    {
        $I->wantTo('check for type when creating widget block as admin user');
        $I->loginAsAdmin();
        $I->sendPOST(
            $this->url,
            [
                'type'         => 'widget',
                'translations' => [
                    'langCode' => 'en',
                    'title'    => 'Example block title',
                    'body'     => 'Example block body'
                ]
            ]
        );
        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'code'    => 400,
                'message' => 'Widget is required',
            ]
        );
    }

    /*
     |--------------------------------------------------------------------------
     | END Block tests
     |--------------------------------------------------------------------------
     */

    /*
     |--------------------------------------------------------------------------
     | START Block translations tests
     |--------------------------------------------------------------------------
     */

    public function CreateBlockTranslations(FunctionalTester $I)
    {
        $I->wantTo('create block translations as admin user');
        $I->loginAsAdmin();
        $user  = $I->haveUser();
        $block = $I->haveBlock(
            [
                'type'         => 'basic',
                'region'       => 'header',
                'weight'       => 1,
                'filter'       => ['+' => ['1/2/3']],
                'options'      => ['option' => 'value'],
                'isActive'     => true,
                'isCacheable'  => true,
                'translations' => [
                    'langCode'     => 'en',
                    'title'        => 'Example block title',
                    'body'         => 'Example block body',
                    'customFields' => ['customField' => "Example block custom field"],

                ]
            ],
            $user
        );
        $I->sendPost(
            $this->url . '/' . $block->id . '/translations',
            [
                'langCode'     => 'en',
                'title'        => 'New block title',
                'body'         => 'New block body',
                'customFields' => ['customField' => "New block custom field"],
            ]
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [

                'langCode'     => 'en',
                'title'        => 'New block title',
                'body'         => 'New block body',
                'customFields' => ['customField' => "New block custom field"],
            ]
        );
    }

    public function UpdateBlockTranslations(FunctionalTester $I)
    {
        $I->wantTo('update block translations as admin user');
        $I->loginAsAdmin();
        $user  = $I->haveUser();
        $block = $I->haveBlock(
            [
                'type'         => 'basic',
                'region'       => 'header',
                'weight'       => 1,
                'filter'       => ['+' => ['1/2/3']],
                'options'      => ['option' => 'value'],
                'isActive'     => true,
                'isCacheable'  => true,
                'translations' => [
                    'langCode'     => 'en',
                    'title'        => 'Example block title',
                    'body'         => 'Example block body',
                    'customFields' => ['customField' => "Example block custom field"],

                ]
            ],
            $user
        );
        $I->sendPUT(
            $this->url . '/' . $block->id . '/translations/en',
            [
                'langCode'     => 'en',
                'title'        => 'Modified block title',
                'body'         => 'Modified block body',
                'customFields' => ['customField' => "Modified block custom field"],
            ]
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [

                'langCode'     => 'en',
                'title'        => 'Modified block title',
                'body'         => 'Modified block body',
                'customFields' => ['customField' => "Modified block custom field"],
            ]
        );
    }

    public function DeleteBlockTranslations(FunctionalTester $I)
    {
        $I->wantTo('delete block translations as admin user');
        $I->loginAsAdmin();
        $user  = $I->haveUser();
        $block = $I->haveBlock(
            [
                'type'         => 'basic',
                'region'       => 'header',
                'weight'       => 1,
                'filter'       => ['+' => ['1/2/3']],
                'options'      => ['option' => 'value'],
                'isActive'     => true,
                'isCacheable'  => true,
                'translations' => [
                    'langCode'     => 'en',
                    'isActive'     => false,
                    'title'        => 'Example block title',
                    'body'         => 'Example block body',
                    'customFields' => ['customField' => "Example block custom field"],
                ]
            ],
            $user
        );
        $I->sendPUT(
            $this->url . '/' . $block->id . '/translations/en',
            [
                'langCode'     => 'en',
                'title'        => 'New block title',
                'body'         => 'New block body',
                'customFields' => ['customField' => "New block custom field"],
            ]
        );
        // get inactive translation
        $blockTranslations = $block->translations(false)->first();

        $I->sendDELETE(
            $this->url . '/' . $block->id . '/translations/' . $blockTranslations->id
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'success' => true,
            ]
        );
    }

    public function itHandlesNullCustomFieldsInTranslations(FunctionalTester $I)
    {
        $I->wantTo('handle null custom fields in block translations as admin user');
        $I->loginAsAdmin();
        $user  = $I->haveUser();
        $block = $I->haveBlock(
            [
                'type'   => 'basic',
                'region' => 'header',
            ],
            $user
        );
        $I->sendPost(
            $this->url . '/' . $block->id . '/translations',
            [
                'langCode'     => 'en',
                'title'        => 'New block title',
                'body'         => 'New block body',
                'customFields' => null,
            ]
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [

                'langCode'     => 'en',
                'title'        => 'New block title',
                'body'         => 'New block body',
                'customFields' => null,
            ]
        );
    }

    public function PreventsDeleteBlockActiveTranslations(FunctionalTester $I)
    {
        $I->wantTo('prevent delete block active translations as admin user');
        $I->loginAsAdmin();
        $user              = $I->haveUser();
        $block             = $I->haveBlock(
            [
                'type'         => 'basic',
                'region'       => 'header',
                'weight'       => 1,
                'filter'       => ['+' => ['1/2/3']],
                'options'      => ['option' => 'value'],
                'isActive'     => true,
                'isCacheable'  => true,
                'translations' => [
                    'langCode'     => 'en',
                    'title'        => 'Example block title',
                    'body'         => 'Example block body',
                    'customFields' => ['customField' => "Example block custom field"],
                ]
            ],
            $user
        );
        $blockTranslations = $block->translations->first();

        $I->sendDELETE(
            $this->url . '/' . $block->id . '/translations/' . $blockTranslations->id
        );
        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'code'    => 400,
                'message' => 'Cannot delete active translation',
            ]
        );
    }

    /*
     |--------------------------------------------------------------------------
     | END Block translations tests
     |--------------------------------------------------------------------------
     */
}
