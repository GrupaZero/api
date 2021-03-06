<?php

namespace Api;

use Illuminate\Support\Facades\Hash;

class AdminUserCest {
    /**
     * @var string endpoint url
     */
    protected $url = 'http://api.localhost/v1/admin/users';

    /*
     |--------------------------------------------------------------------------
     | START User list tests
     |--------------------------------------------------------------------------
     */

    public function getUsers(FunctionalTester $I)
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
                    'total'       => $usersNumber + 1,
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
        $user = $I->haveUser(
            [
                'nick'       => 'Test user',
                'first_name' => 'John',
                'last_name'  => 'Doe',
                'password'   => Hash::make('test123')
            ]
        );
        $I->sendGet(
            $this->url . '/' . $user->id
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'nick'      => 'Test user',
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
                'message' => "Not found",
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

    public function updateUser(FunctionalTester $I)
    {
        $I->wantTo('update user as admin user');
        $I->loginAsAdmin();
        $user = $I->haveUser();
        $I->sendPUT(
            $this->url . '/' . $user->id,
            [
                'nick'      => 'Modified user',
                'firstName' => 'Johny',
                'lastName'  => 'Stark',
                'email'     => $user->email,
            ]
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'nick'      => 'Modified user',
                'firstName' => 'Johny',
                'lastName'  => 'Stark',
                'email'     => $user->email,
            ]
        );
    }

    public function checksIfUserExistsWhenUpdating(FunctionalTester $I)
    {
        $I->wantTo('checks for user when updating user as admin user');
        $I->loginAsAdmin();
        $I->sendPUT($this->url . '/4');
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'message' => "Not found",
            ]
        );
    }

    public function deleteUser(FunctionalTester $I)
    {
        $I->wantTo('delete user as admin user');
        $I->loginAsAdmin();
        $user = $I->haveUser();
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
