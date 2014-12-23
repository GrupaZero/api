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
class ContentValidator extends AbstractValidator {

    /**
     * @var array
     */
    protected $rules = [
        'list'   => [
            'lang'               => 'required_with:translations_title,sort|in:pl,en',
            'page'               => 'numeric',
            'perPage'            => 'numeric',
            'type'               => 'in:content,category',
            'parentId'           => 'numeric',
            'isActive'           => 'boolean',
            'sort'               => '',
            'level'              => '',
            'translations_title' => ''
        ],
        'create' => [
            'lang'         => 'required_with:translations',
            'type'         => 'required|in:content,category',
            'isActive'     => '',
            'translations' => ''
        ]
    ];

    /**
     * @var array
     */
    protected $filters = [
        'title' => 'trim'
    ];
}
