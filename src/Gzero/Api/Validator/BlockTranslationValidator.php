<?php namespace Gzero\Api\Validator;

use Gzero\Validator\AbstractValidator;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class BlockTranslationValidator
 *
 * @package    Gzero\Api\Validator
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class BlockTranslationValidator extends AbstractValidator {

    /**
     * @var array
     */
    protected $rules = [
        'list'   => [
            'langCode' => 'in:pl,en,de,fr',
            'page'     => 'numeric',
            'perPage'  => 'numeric',
            'isActive' => 'boolean',
            'sort'     => '',
            'level'    => ''
        ],
        'create' => [
            'langCode'     => 'required|in:pl,en,de,fr',
            'isActive'     => '',
            'title'        => 'required',
            'body'         => '',
            'customFields' => '',
        ]
    ];

    /**
     * @var array
     */
    protected $filters = [
        'title' => 'trim',
    ];
}