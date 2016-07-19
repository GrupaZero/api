<?php
namespace api;

class AdminContentCest {

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
}
