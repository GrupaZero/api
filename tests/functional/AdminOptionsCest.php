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

        $I->sendPATCH(
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
}
