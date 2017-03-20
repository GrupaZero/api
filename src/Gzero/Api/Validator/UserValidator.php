<?php namespace Gzero\Api\Validator;

use Gzero\Validator\AbstractValidator;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class ContentParamsValidator
 *
 * @package    Gzero\Api\Validator
 * @author     Mateusz Urbanowicz <urbanowiczmateusz89@gmail.com>
 * @copyright  Copyright (c) 2015, Mateusz Urbanowicz
 */
class UserValidator extends AbstractValidator {

    /**
     * @var array
     */
    protected $rules = [
        'list'   => [
            'page'     => 'numeric',
            'per_page' => 'numeric',
            'sort'     => '',
        ],
        'update' => [
            'email'      => 'required|email|unique:users,email,@user_id',
            'nick'       => 'required|min:3|unique:users,nick,@user_id',
            'first_name' => '',
            'last_name'  => ''
        ]
    ];

}
