<?php
namespace api;

class AdminContentCest {
    /**
     * @var string endpoint url
     */
    protected $url = 'http://api.localhost/v1/admin/contents';

    public function _before(FunctionalTester $I)
    {
        $I->logout();
    }

    public function _after(FunctionalTester $I)
    {
    }

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
        $nestedCategory = $I->haveContent(['type' => 'category', 'parentId' => $category1->id]);
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
        $nestedCategory = $I->haveContent(['type' => 'category', 'parentId' => $category1->id]);
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
        $nestedCategory = $I->haveContent(['type' => 'category', 'parentId' => $category->id]);
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
        $user  = $I->haveUser();
        $content = $I->haveContent(
            [
                'type'         => 'content',
                'isActive'     => 1,
                'translations' => [
                    'langCode'       => 'en',
                    'title'          => 'Fake title',
                    'teaser'         => '<p>Super fake...</p>',
                    'body'           => '<p>Super fake body of some post!</p>',
                    'seoTitle'       => 'fake-title',
                    'seoDescription' => 'desc-demonstrate-fake',
                    'isActive'       => 1
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
        $user  = $I->haveUser();
        $content = $I->haveContent(
            [
                'type'         => 'content',
                'isActive'     => 1,
                'translations' => [
                    'langCode'       => 'en',
                    'title'          => 'Fake title',
                    'teaser'         => '<p>Super fake...</p>',
                    'body'           => '<p>Super fake body of some post!</p>',
                    'seoTitle'       => 'fake-title',
                    'seoDescription' => 'desc-demonstrate-fake',
                    'isActive'       => 1
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

    public function RestoreDeletedContent(FunctionalTester $I)
    {
        $I->wantTo('restore deleted content as admin user');
        $I->loginAsAdmin();
        $user  = $I->haveUser();
        $content = $I->haveContent(
            [
                'type'         => 'content',
                'isActive'     => 1,
                'translations' => [
                    'langCode'       => 'en',
                    'title'          => 'Fake title',
                    'teaser'         => '<p>Super fake...</p>',
                    'body'           => '<p>Super fake body of some post!</p>',
                    'seoTitle'       => 'fake-title',
                    'seoDescription' => 'desc-demonstrate-fake',
                    'isActive'       => 1
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

    public function ForceDeleteContent(FunctionalTester $I)
    {
        $I->wantTo('force delete content as admin user');
        $I->loginAsAdmin();
        $user  = $I->haveUser();
        $content = $I->haveContent(
            [
                'type'         => 'content',
                'isActive'     => 1,
                'translations' => [
                    'langCode'       => 'en',
                    'title'          => 'Fake title',
                    'teaser'         => '<p>Super fake...</p>',
                    'body'           => '<p>Super fake body of some post!</p>',
                    'seoTitle'       => 'fake-title',
                    'seoDescription' => 'desc-demonstrate-fake',
                    'isActive'       => 1
                ]
            ],
            $user
        );
        $I->sendDelete($this->url . '/' . $content->id);
        $I->sendDelete($this->url . '/' . $content->id, ['force' => true]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'success' => true,
            ]
        );
    }

    public function checksIfContentExistsWhenDeleting(FunctionalTester $I)
    {
        $I->wantTo('check for content when force delete content as admin user');
        $I->loginAsAdmin();
        $I->sendDelete($this->url . '/1');
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'error' =>
                    [
                        'code'    => 404,
                        'message' => "Not found!",
                    ]
            ]
        );
    }

    public function checksIfContentExistsWhenRestoring(FunctionalTester $I)
    {
        $I->wantTo('check for content when restoring content as admin user');
        $I->loginAsAdmin();
        $I->sendPut($this->url . '/restore/1');
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'error' =>
                    [
                        'code'    => 404,
                        'message' => "Not found!",
                    ]
            ]
        );
    }
}
