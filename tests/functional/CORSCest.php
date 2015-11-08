<?php
namespace api;

class CORSCest {

    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function contentValidationError(FunctionalTester $I)
    {
        $I->wantTo('try to POST content without body as an admin user');
        $I->loginAsAdmin();
        $I->haveHttpHeader('X-Requested-With', 'XMLHttpRequest');
        $I->sendPOST('http://api.localhost/v1/admin/contents');
        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'code'  => 400,
                'error' =>
                    [
                        'type'                  => ['The type field is required.'],
                        'translations.langCode' => ['The translations.lang code field is required.'],
                        'translations.title'    => ['The translations.title field is required.']
                    ]
            ]

        );
    }

    public function MethodNotAllowedHttpException(FunctionalTester $I)
    {
        $I->wantTo('try to POST options as an admin user');
        $I->loginAsAdmin();
        $I->haveHttpHeader('X-Requested-With', 'XMLHttpRequest');
        $I->sendPOST('http://api.localhost/v1/admin/options');
        $I->seeResponseCodeIs(500);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'code'  => 500,
                'error' =>
                    [
                        'type' => 'Symfony\\Component\\HttpKernel\\Exception\\MethodNotAllowedHttpException',
                    ]
            ]

        );
    }
}
