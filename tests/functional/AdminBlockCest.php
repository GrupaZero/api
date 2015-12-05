<?php
namespace api;

class AdminBlockCest {

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
}
