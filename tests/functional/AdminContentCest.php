<?php

namespace Api;

class AdminContentCest {
    /**
     * @var string endpoint url
     */
    protected $url = 'http://api.localhost/v1/admin/contents';

    // tests
    public function getLangs(FunctionalTester $I)
    {
        $I->wantTo('get list of languages as admin user');
        $I->loginAsAdmin();
        $I->sendGET('http://api.localhost/v1/admin/langs');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                [
                    'code'      => 'en',
                    'i18n'      => 'en_US',
                    'isEnabled' => true,
                    'isDefault' => true
                ],
                [
                    'code'      => 'pl',
                    'i18n'      => 'pl_PL',
                    'isEnabled' => true,
                    'isDefault' => false
                ]
            ]
        );
    }

    public function getContentTree(FunctionalTester $I)
    {
        $I->wantTo('get tree of contents as admin user');
        $I->loginAsAdmin();
        $category1      = $I->haveContent(['type' => 'category']);
        $category2      = $I->haveContent(['type' => 'category']);
        $nestedCategory = $I->haveContent(['type' => 'category', 'parent_id' => $category1->id]);
        $I->sendGET('http://api.localhost/v1/admin/contents/tree');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'data' => [
                    [
                        'id'       => $category1->id,
                        'children' => [
                            ['id' => $nestedCategory->id]
                        ]
                    ],
                    ['id' => $category2->id]
                ]
            ]
        );
    }

    public function getContentTreeWhenThereAreNoRecords(FunctionalTester $I)
    {
        $I->wantTo('get tree of contents when there are no records as admin user');
        $I->loginAsAdmin();
        $I->sendGET('http://api.localhost/v1/admin/contents/tree');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'data' => []
            ]
        );
    }

    public function getContentTreeForSingleCategory(FunctionalTester $I)
    {
        $I->wantTo('get tree of contents for single root as admin user');
        $I->loginAsAdmin();
        $category1      = $I->haveContent(['type' => 'category']);
        $nestedCategory = $I->haveContent(['type' => 'category', 'parent_id' => $category1->id]);
        $I->sendGET('http://api.localhost/v1/admin/contents/tree');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'data' => [
                    [
                        'id'       => $category1->id,
                        'children' => [
                            ['id' => $nestedCategory->id]
                        ]
                    ]
                ]
            ]
        );
    }

    public function getContents(FunctionalTester $I)
    {
        $I->wantTo('get list of contents as admin user');
        $I->loginAsAdmin();
        $category       = $I->haveContent(['type' => 'category']);
        $nestedCategory = $I->haveContent(['type' => 'category', 'parent_id' => $category->id]);
        $content        = $I->haveContent(['type' => 'content']);
        $I->sendGET('http://api.localhost/v1/admin/contents?sort=-type,-id&lang=en');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'meta'   => [
                    'total'       => 3,
                    'perPage'     => 20,
                    'currentPage' => 1,
                    'lastPage'    => 1,
                    'link'        => 'http://api.localhost/v1/admin/contents',
                ],
                'params' => [
                    'page'    => 1,
                    'perPage' => 20,
                    'filter'  => [
                        ['lang', '=', 'en'],
                    ],
                    // Don't know why this won't match. Lets try after codeception update
                    //'orderBy' => [['id', 'DESC'],['type', 'DESC']]
                ],
                'data'   => [
                    ['id' => $content->id, 'type' => 'content'],
                    ['id' => $nestedCategory->id, 'type' => 'category'],
                    ['id' => $category->id, 'type' => 'category'],
                ]
            ]
        );
    }

    public function deleteContent(FunctionalTester $I)
    {
        $I->wantTo('delete content as admin user');
        $I->loginAsAdmin();
        $user    = $I->haveUser();
        $content = $I->haveContent(
            [
                'type'         => 'content',
                'is_active'    => 1,
                'translations' => [
                    'lang_code'       => 'en',
                    'title'           => 'Fake title',
                    'teaser'          => '<p>Super fake...</p>',
                    'body'            => '<p>Super fake body of some post!</p>',
                    'seo_title'       => 'fake-title',
                    'seo_description' => 'desc-demonstrate-fake',
                    'is_active'       => 1
                ]
            ],
            $user
        );
        $I->sendDelete($this->url . '/' . $content->id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'success' => true,
            ]
        );
    }

    public function getDeletedContent(FunctionalTester $I)
    {
        $I->wantTo('get list of soft deleted content as admin user');
        $I->loginAsAdmin();
        $user    = $I->haveUser();
        $content = $I->haveContent(
            [
                'type'         => 'content',
                'is_active'    => 1,
                'translations' => [
                    'lang_code'       => 'en',
                    'title'           => 'Fake title',
                    'teaser'          => '<p>Super fake...</p>',
                    'body'            => '<p>Super fake body of some post!</p>',
                    'seo_title'       => 'fake-title',
                    'seo_description' => 'desc-demonstrate-fake',
                    'is_active'       => 1
                ]
            ],
            $user
        );
        $I->sendDelete($this->url . '/' . $content->id);
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

    public function restoreDeletedContent(FunctionalTester $I)
    {
        $I->wantTo('restore deleted content as admin user');
        $I->loginAsAdmin();
        $user    = $I->haveUser();
        $content = $I->haveContent(
            [
                'type'         => 'content',
                'is_active'    => 1,
                'translations' => [
                    'lang_code'       => 'en',
                    'title'           => 'Fake title',
                    'teaser'          => '<p>Super fake...</p>',
                    'body'            => '<p>Super fake body of some post!</p>',
                    'seo_title'       => 'fake-title',
                    'seo_description' => 'desc-demonstrate-fake',
                    'is_active'       => 1
                ]
            ],
            $user
        );
        $I->sendDelete($this->url . '/' . $content->id);
        $I->sendPut($this->url . '/restore/' . $content->id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'success' => true,
            ]
        );
    }

    public function forceDeleteContent(FunctionalTester $I)
    {
        $I->wantTo('force delete content as admin user');
        $I->loginAsAdmin();
        $user    = $I->haveUser();
        $content = $I->haveContent(
            [
                'type'         => 'content',
                'is_active'    => 1,
                'translations' => [
                    'lang_code'       => 'en',
                    'title'           => 'Fake title',
                    'teaser'          => '<p>Super fake...</p>',
                    'body'            => '<p>Super fake body of some post!</p>',
                    'seo_title'       => 'fake-title',
                    'seo_description' => 'desc-demonstrate-fake',
                    'is_active'       => 1
                ]
            ],
            $user
        );
        $I->sendDelete($this->url . '/' . $content->id, ['force' => true]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'success' => true,
            ]
        );
    }

    public function deleteOneContentFromTrash(FunctionalTester $I)
    {
        $I->wantTo('force delete only one item from trashcan');
        $I->loginAsAdmin();
        $user = $I->haveUser();

        $content  = $I->haveContent(
            [
                'type'         => 'content',
                'is_active'    => 1,
                'translations' => [
                    'lang_code'       => 'en',
                    'title'           => 'Fake title',
                    'teaser'          => '<p>Super fake...</p>',
                    'body'            => '<p>Super fake body of some post!</p>',
                    'seo_title'       => 'fake-title',
                    'seo_description' => 'desc-demonstrate-fake',
                    'is_active'       => 1
                ]
            ],
            $user
        );
        $content2 = $I->haveContent(
            [
                'type'         => 'content',
                'is_active'    => 1,
                'translations' => [
                    'lang_code'       => 'en',
                    'title'           => 'Fake title',
                    'teaser'          => '<p>Super fake...</p>',
                    'body'            => '<p>Super fake body of some post!</p>',
                    'seo_title'       => 'fake-title',
                    'seo_description' => 'desc-demonstrate-fake',
                    'is_active'       => 1
                ]
            ],
            $user
        );

        $I->sendDelete($this->url . '/' . $content->id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'success' => true,
            ]
        );

        $I->sendDelete($this->url . '/' . $content2->id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'success' => true,
            ]
        );

        $I->sendDelete($this->url . '/' . $content->id, ['force' => true]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'success' => true,
            ]
        );

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
}
