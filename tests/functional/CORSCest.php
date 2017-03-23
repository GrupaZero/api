<?php

namespace Api;

class CORSCest {

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
        $I->seeResponseCodeIs(422);
        // Asserting CORS
        $I->seeHttpHeader('Access-Control-Allow-Credentials', 'true');
        $I->seeHttpHeader('Access-Control-Allow-Origin', 'http://localhost');
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'error' => [
                    'message' => 'Validation Error',
                    'errors'  => [
                        'type'                  => [0 => 'The type field is required.',],
                        'translations.langCode' => [0 => 'The translations.lang code field is required.',],
                        'translations.title'    => [0 => 'The translations.title field is required.',],
                    ],
                ]
            ]

        );
    }

    public function methodNotAllowedHttpException(FunctionalTester $I)
    {
        $I->wantTo('try to POST options as an admin user');
        $I->loginAsAdmin();
        // Adding AJAX + CORS headers
        $I->haveHttpHeader('X-Requested-With', 'XMLHttpRequest');
        $I->haveHttpHeader('Origin', 'http://localhost');
        $I->sendPOST('http://api.localhost/v1/admin/options');
        $I->seeResponseCodeIs(405);
        // Asserting CORS headers won't be added
        $I->dontSeeHttpHeader('Access-Control-Allow-Credentials', 'true');
        $I->dontSeeHttpHeader('Access-Control-Allow-Origin', 'http://localhost');
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'message' => 'Method Not Allowed',
            ]

        );
    }
}
