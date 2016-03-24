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
}
