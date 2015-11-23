<?php
namespace api;

class AdminOptionsCest {

    /**
     * @var string endpoint url
     */
    protected $url = 'http://api.localhost/v1/admin/options';

    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function getOptionsCategories(FunctionalTester $I)
    {
        $I->wantTo('get list of options categories as admin user');
        $I->loginAsAdmin();

        $I->haveHttpHeader('X-Requested-With', 'XMLHttpRequest');
        $I->haveHttpHeader('Origin', 'http://localhost');
        $I->sendGET($this->url);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'data' => [
                    ['key' => 'general'],
                    ['key' => 'seo']
                ]
            ]
        );
    }

    public function getOptionsFromGivenCategory(FunctionalTester $I)
    {
        $I->wantTo('get all options from given category as admin user');
        $I->loginAsAdmin();

        $I->haveHttpHeader('X-Requested-With', 'XMLHttpRequest');
        $I->haveHttpHeader('Origin', 'http://localhost');
        $I->sendGET($this->url . '/seo');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'googleAnalyticsId' =>
                    [
                        'en' => null,
                        'pl' => null,
                        'de' => null,
                        'fr' => null,
                    ],
                'seoDescLength'     =>
                    [
                        'en' => 160,
                        'pl' => 160,
                        'de' => 160,
                        'fr' => 160,
                    ],
            ]
        );
    }

    public function updateOptionValue(FunctionalTester $I)
    {
        $I->wantTo('update value of option as admin user');
        $I->loginAsAdmin();

        $I->haveHttpHeader('X-Requested-With', 'XMLHttpRequest');
        $I->haveHttpHeader('Origin', 'http://localhost');
        $I->sendPUT(
            $this->url . '/seo',
            [
                'key'   => 'seoDescLength',
                'value' => [
                    'en' => 160,
                    'pl' => 161,
                    'de' => 162,
                    'fr' => 163,
                ],
            ]
        );

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'googleAnalyticsId' =>
                    [
                        'en' => null,
                        'pl' => null,
                        'de' => null,
                        'fr' => null,
                    ],
                'seoDescLength'     =>
                    [
                        'en' => 160,
                        'pl' => 161,
                        'de' => 162,
                        'fr' => 163,
                    ],
            ]
        );
    }

    public function getOptionsFromNonExistingCategory(FunctionalTester $I)
    {
        $I->wantTo('get options from category that not exists as admin user');
        $I->loginAsAdmin();

        $I->haveHttpHeader('X-Requested-With', 'XMLHttpRequest');
        $I->haveHttpHeader('Origin', 'http://localhost');
        $I->sendGET($this->url . '/some_category');
        $I->seeResponseCodeIs(500);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'error' =>
                    [
                        'code'    => 500,
                        'message' => 'category some_category does not exist',
                    ],
            ]
        );
    }

    public function updateNonExistingOption(FunctionalTester $I)
    {
        $I->wantTo('update value of non existing option as admin user');
        $I->loginAsAdmin();

        $I->haveHttpHeader('X-Requested-With', 'XMLHttpRequest');
        $I->haveHttpHeader('Origin', 'http://localhost');
        $I->sendPUT(
            $this->url . '/seo',
            [
                'key'   => 'not_an_option',
                'value' => [
                    ['lorem' => 'ipsum']
                ],
            ]
        );

        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'code'  => 400,
                'error' =>
                    [
                        'key' =>
                            [
                                0 => 'The selected key is invalid.',
                            ],
                    ],
            ]

        );
    }

    public function updateOptionInNonExistingCategory(FunctionalTester $I)
    {
        $I->wantTo('update value of option in non existing category as admin user');
        $I->loginAsAdmin();

        $I->haveHttpHeader('X-Requested-With', 'XMLHttpRequest');
        $I->haveHttpHeader('Origin', 'http://localhost');
        $I->sendPUT(
            $this->url . '/some_category',
            [
                'key'   => 'not_an_option',
                'value' => [
                    ['lorem' => 'ipsum']
                ],
            ]
        );

        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'code'  => 400,
                'error' =>
                    [
                        'key' =>
                            [
                                0 => 'The selected key is invalid.',
                            ],
                    ],
            ]

        );
    }
}
