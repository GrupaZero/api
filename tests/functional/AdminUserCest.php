<?php
namespace api;

class AdminUserCest {
    /**
     * @var string endpoint url
     */
    protected $url = 'http://api.localhost/v1/admin/users';

    public function _before(FunctionalTester $I)
    {
        $I->logout();
    }

    public function _after(FunctionalTester $I)
    {
    }

    /*
     |--------------------------------------------------------------------------
     | START User list tests
     |--------------------------------------------------------------------------
     */

    public function getBlocks(FunctionalTester $I)
    {
        $I->wantTo('get list of users as admin user');
        $I->loginAsAdmin();
        $usersNumber = 4;
        for ($i = 0; $i < $usersNumber; $i++) {
            $I->haveUser();
        }
        $I->sendGET($this->url);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'meta'   => [
                    'total'       => $usersNumber,
                    'perPage'     => 20,
                    'currentPage' => 1,
                    'lastPage'    => 1,
                    'link'        => $this->url,
                ],
                'params' => [
                    'page'    => 1,
                    'perPage' => 20,
                    'filter'  => [],
                ],
            ]
        );
    }

    public function getSingleUser(FunctionalTester $I)
    {
        $I->wantTo('get single user as admin user');
        $I->loginAsAdmin();
        $user  = $I->haveUser([
            'nickName'  => 'Test user',
            'firstName' => 'John',
            'lastName'  => 'Doe',
            'password'  => Hash::make('test123')
        ]);
        $I->sendGet(
            $this->url . '/' . $user->id
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'nickName'  => 'Test user',
                'firstName' => 'John',
                'lastName'  => 'Doe',
            ]
        );
    }

    public function checksIfUserExistsWhenGetting(FunctionalTester $I)
    {
        $I->wantTo('checks for user when getting user as admin user');
        $I->loginAsAdmin();
        $I->sendPUT($this->url . '/4');
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

    /*
     |--------------------------------------------------------------------------
     | END User list tests
     |--------------------------------------------------------------------------
     */

    /*
     |--------------------------------------------------------------------------
     | START User tests
     |--------------------------------------------------------------------------
     */

    public function UpdateUser(FunctionalTester $I)
    {
        $I->wantTo('update user as admin user');
        $I->loginAsAdmin();
        $user  = $I->haveUser([
            'nickName'  => 'Test user',
            'firstName' => 'John',
            'lastName'  => 'Doe',
            'password'  => Hash::make('test123')
        ]);
        $I->sendPUT(
            $this->url . '/' . $user->id,
            [
                'nickName'  => 'Modified user',
                'firstName' => 'Johny',
                'lastName'  => 'Stark',
            ]
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'nickName'  => 'Modified user',
                'firstName' => 'Johny',
                'lastName'  => 'Stark',
            ]
        );
    }

    public function checksIfBlockExistsWhenUpdating(FunctionalTester $I)
    {
        $I->wantTo('checks for user when updating user as admin user');
        $I->loginAsAdmin();
        $I->sendPUT($this->url . '/4');
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

    public function DeleteUser(FunctionalTester $I)
    {
        $I->wantTo('delete block as admin user');
        $I->loginAsAdmin();
        $user  = $I->haveUser([
            'nickName'  => 'Test user',
            'firstName' => 'John',
            'lastName'  => 'Doe',
            'password'  => Hash::make('test123')
        ]);
        $I->sendDelete($this->url . '/' . $user->id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'success' => true,
            ]
        );
    }


    /*
     |--------------------------------------------------------------------------
     | END User tests
     |--------------------------------------------------------------------------
     */
}
