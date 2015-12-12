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

    // tests
    public function getBlocks(FunctionalTester $I)
    {
        $I->wantTo('get list of blocks as admin user');
        $I->loginAsAdmin();
        $I->sendGET('http://api.localhost/v1/admin/blocks');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'meta'   => [
                    'total'       => 0,
                    'perPage'     => 20,
                    'currentPage' => 1,
                    'lastPage'    => 0,
                    'link'        => 'http://api.localhost/v1/admin/blocks',
                ],
                'params' => [
                    'page'    => 1,
                    'perPage' => 20,
                    'filter'  => [],
                ],
            ]
        );
    }

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
}
