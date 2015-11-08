<?php
namespace api;

class CORSCest {

    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
        $I->logout();
    }

    // tests
    public function allowedHeadersOPTIONS(FunctionalTester $I)
    {
        $I->wantTo('try get languages list as an admin user');
        $I->loginAsAdmin();
        // Adding CORS headers with x-requested-with
        $I->haveHttpHeader('Access-Control-Request-Headers', 'accept, x-requested-with');
        $I->haveHttpHeader('Access-Control-Request-Method', 'GET');
        $I->haveHttpHeader('Origin', 'http://localhost');
        $I->sendOPTIONS('http://api.localhost/v1/admin/langs');
        $I->seeResponseCodeIs(200);
        // Asserting CORS
        $I->seeHttpHeader('Access-Control-Allow-Credentials', 'true');
        $I->seeHttpHeader('Access-Control-Allow-Origin', 'http://localhost');
    }

    public function contentPOSTSuccessResponse(FunctionalTester $I)
    {
        $I->wantTo('try to POST content as an admin user');
        $I->loginAsAdmin();
        // Adding AJAX + CORS headers
        $I->haveHttpHeader('X-Requested-With', 'XMLHttpRequest');
        $I->haveHttpHeader('Origin', 'http://localhost');
        $I->sendPOST(
            'http://api.localhost/v1/admin/contents',
            [
                'type'         => 'content',
                'translations' => [
                    'title'    => 'test',
                    'langCode' => 'en',
                ]
            ]
        );
        $I->seeResponseCodeIs(200);
        // Asserting CORS
        $I->seeHttpHeader('Access-Control-Allow-Credentials', 'true');
        $I->seeHttpHeader('Access-Control-Allow-Origin', 'http://localhost');
        $I->seeResponseIsJson();
    }

    public function contentValidationError(FunctionalTester $I)
    {
        $I->wantTo('try to POST content without body as an admin user');
        $I->loginAsAdmin();
        // Adding AJAX + CORS headers
        $I->haveHttpHeader('X-Requested-With', 'XMLHttpRequest');
        $I->haveHttpHeader('Origin', 'http://localhost');
        $I->sendPOST('http://api.localhost/v1/admin/contents');
        $I->seeResponseCodeIs(400);
        // Asserting CORS
        $I->seeHttpHeader('Access-Control-Allow-Credentials', 'true');
        $I->seeHttpHeader('Access-Control-Allow-Origin', 'http://localhost');
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
        // Adding AJAX + CORS headers
        $I->haveHttpHeader('X-Requested-With', 'XMLHttpRequest');
        $I->haveHttpHeader('Origin', 'http://localhost');
        $I->sendPOST('http://api.localhost/v1/admin/options');
        $I->seeResponseCodeIs(500);
        // Asserting CORS
        $I->seeHttpHeader('Access-Control-Allow-Credentials', 'true');
        $I->seeHttpHeader('Access-Control-Allow-Origin', 'http://localhost');
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'code'  => 500,
                'error' =>
                    [
                        'message' => 'Internal Server Error',
                    ]
            ]

        );
    }
}