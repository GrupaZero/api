<?php
namespace api;

class AdminBlockCest {
    /**
     * @var string endpoint url
     */
    protected $url = 'http://api.localhost/v1/admin/blocks';

    public function _before(FunctionalTester $I)
    {
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

    /*
     |--------------------------------------------------------------------------
     | END Block list tests
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
                                'lang'  => 'en',
                                'title' => 'Example block title',
                                'body'  => 'Example block body',
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
                            'lang'  => 'en',
                            'title' => 'Example block title',
                            'body'  => 'Example block body',
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
                'options'     => ['option' => ' new value'],
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
                'options'     => ['option' => ' new value'],
                'isActive'    => false,
                'isCacheable' => false
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

    public function checksWidgetFieldWhenCreatingWidgetBlock(FunctionalTester $I)
    {
        $I->wantTo('checks for widget field when creating block as admin user');
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
                'code'  => 400,
                'error' =>
                    [
                        'type' => ["The selected type is invalid."],
                    ]
            ]
        );
    }

    public function checksTypeWhenCreatingBlock(FunctionalTester $I)
    {
        $I->wantTo('checks for type when creating widget block as admin user');
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
        $I->seeResponseCodeIs(500);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'code'  => 500,
                'error' =>
                    [
                        'message' => 'Widget is required',
                    ]
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

                'lang'         => 'en',
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

                'lang'         => 'en',
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
        $I->seeResponseCodeIs(500);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'code'  => 500,
                'error' =>
                    [
                        'message' => 'Cannot delete active translation',
                    ]
            ]
        );
    }

    /*
     |--------------------------------------------------------------------------
     | END Block translations tests
     |--------------------------------------------------------------------------
     */
}
