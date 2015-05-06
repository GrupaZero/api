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
 * @author     Adrian Skierniewski <urbanowiczmateusz89@gmail.com.com>
 * @copyright  Copyright (c) 2015, Mateusz Urbanowicz
 */
class UserValidator extends AbstractValidator {

    /**
     * @var array
     */
    protected $rules = [
        'list' => [
            'page'     => 'numeric',
            'perPage'  => 'numeric',
            'sort'     => '',
        ],
    ];

    /**
     * @var array
     */
    protected $filters = [
        'title' => 'trim'
    ];
}
