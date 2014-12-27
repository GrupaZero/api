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
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class ContentTranslationValidator extends AbstractValidator {

    /**
     * @var array
     */
    protected $rules = [
        'list'   => [
            'langCode' => 'in:pl,en',
            'page'     => 'numeric',
            'perPage'  => 'numeric',
            'isActive' => 'boolean',
            'sort'     => '',
            'level'    => ''
        ],
        'create' => [
            'langCode' => 'required|in:pl,en',
            'isActive' => '',
            'title'    => 'required',
            'body'     => ''
        ]
    ];

    /**
     * @var array
     */
    protected $filters = [
        'title' => 'trim'
    ];
}
