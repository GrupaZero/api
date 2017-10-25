<?php namespace Gzero\Api\Validator;

use Gzero\Validator\AbstractValidator;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class AccountValidator
 */
class AccountValidator extends AbstractValidator {

    /**
     * @var array
     */
    protected $rules = [
        'update' => [
            'email'                 => 'required|email|unique:users,email,@user_id',
            'nick'                  => 'required|min:3|unique:users,nick,@user_id',
            'first_name'            => 'min:2|regex:/^([^0-9]*)$/', // without numbers
            'last_name'             => 'min:2|regex:/^([^0-9]*)$/', // without numbers
            'password'              => 'sometimes|min:6|same:password_confirmation|required_with:password_confirmation',
            'password_confirmation' => 'sometimes|min:6|same:password|required_with:password',
        ],
        'update_without_email' => [
            'nick'                  => 'required|min:3|unique:users,nick,@user_id',
            'first_name'            => 'min:2|regex:/^([^0-9]*)$/', // without numbers
            'last_name'             => 'min:2|regex:/^([^0-9]*)$/', // without numbers
            'password'              => 'sometimes|min:6|same:password_confirmation|required_with:password_confirmation',
            'password_confirmation' => 'sometimes|min:6|same:password|required_with:password',
        ]
    ];
}
