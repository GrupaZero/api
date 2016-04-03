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
            'page'    => 'numeric',
            'perPage' => 'numeric',
            'sort'    => '',
        ],
        'update' => [
            'email'     => 'required|email|unique:Users,email,@userId',
            'nickName'  => 'required|min:3|unique:Users,nickName,@userId',
            'firstName' => '',
            'lastName'  => ''
        ]
    ];

}
