<?php

namespace Api;

use Illuminate\Support\Facades\Hash;

class FrontendAccountCest {
    /**
     * @var string endpoint url
     */
    protected $url = 'http://api.localhost/v1/account';

    /*
     |--------------------------------------------------------------------------
     | START Account tests
     |--------------------------------------------------------------------------
     */

    public function UpdateAccount(FunctionalTester $I)
    {
        $I->wantTo('update my account data');
        $user = $I->haveUser();
        $I->loginWithToken($user->email);
        $I->sendPUT(
            $this->url,
            [
                'nick'      => 'Modified user',
                'firstName' => 'Johny',
                'lastName'  => 'Stark',
                'email'     => 'newEmail@example.com'
            ]
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'nick'      => 'Modified user',
                'firstName' => 'Johny',
                'lastName'  => 'Stark',
                'email'     => 'newEmail@example.com',
            ]
        );
    }

    public function UpdatePassword(FunctionalTester $I)
    {
        $I->wantTo('update my password');
        $user = $I->haveUser();
        $I->loginWithToken($user->email);
        $I->sendPUT(
            $this->url,
            [
                'nick'                  => $user->nick,
                'email'                 => $user->email,
                'password'              => 'newPassword',
                'password_confirmation' => 'newPassword',
            ]
        );
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->deleteHeader('Authorization');
        $I->login($user->email, 'newPassword');
    }

    public function cantChangePasswordWithoutConfirmation(FunctionalTester $I)
    {
        $I->wantTo('update my password without confirmation');
        $user = $I->haveUser();
        $I->loginWithToken($user->email);
        $I->sendPUT(
            $this->url,
            [
                'nick'     => $user->nick,
                'email'    => $user->email,
                'password' => 'newPassword',
            ]
        );
        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'code'    => 400,
                'message' => 'Validation Error',
                'errors'  => [
                    'password' => ['The password and password confirmation must match.']
                ]

            ]
        );
    }

    public function cantChangeNickToAlreadyTaken(FunctionalTester $I)
    {
        $I->wantTo('update my nick to already taken');
        $user  = $I->haveUser();
        $user1 = $I->haveUser();
        $I->loginWithToken($user->email);
        $I->sendPUT(
            $this->url,
            [
                'nick'  => $user1->nick,
                'email' => $user->email,
            ]
        );
        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'code'    => 400,
                'message' => 'Validation Error',
                'errors'  => [
                    'nick' => ['The nick has already been taken.']
                ]

            ]
        );
    }

    public function cantChangeEmailToAlreadyTaken(FunctionalTester $I)
    {
        $I->wantTo('update my email to already taken');
        $user  = $I->haveUser();
        $user1 = $I->haveUser();
        $I->loginWithToken($user->email);
        $I->sendPUT(
            $this->url,
            [
                'nick'  => $user->nick,
                'email' => $user1->email,
            ]
        );
        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(
            [
                'code'    => 400,
                'message' => 'Validation Error',
                'errors'  => [
                    'email' => ['The email has already been taken.']
                ]

            ]
        );
    }

    /*
     |--------------------------------------------------------------------------
     | END Account tests
     |--------------------------------------------------------------------------
     */
}
