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
        'tree'   => [
            'lang'     => 'required_with:sort|in:pl,en',
            'type'     => 'in:category',
            'weight'   => 'numeric',
            'isActive' => 'boolean',
            'sort'     => ''
        ],
        'list'   => [
            'lang'     => 'required_with:sort|in:pl,en',
            'page'     => 'numeric',
            'perPage'  => 'numeric',
            'type'     => 'in:content,category',
            'parentId' => 'numeric',
            'isActive' => 'boolean',
            'sort'     => '',
            'level'    => ''
        ],
        'create' => [
            'type'                  => 'required|in:content,category',
            'parentId'              => 'numeric',
            'isActive'              => '',
            'translations.langCode' => 'required|in:pl,en',
            'translations.title'    => 'required',
            'translations.teaser'   => '',
            'translations.body'     => ''
        ],
        'update' => [
            'parentId' => '',
            'weight'   => '',
            'isActive' => '',
        ]
    ];

    /**
     * @var array
     */
    protected $filters = [
        'translations.title' => 'trim'
    ];
}
