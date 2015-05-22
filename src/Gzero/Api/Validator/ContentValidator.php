<?php namespace Gzero\Api\Validator;

use Gzero\Validator\AbstractValidator;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class ContentValidator
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
            'level'    => '',
            'trashed'  => ''
        ],
        'create' => [
            'type'                  => 'required|in:content,category',
            'parentId'              => 'numeric',
            'isOnHome'              => 'boolean',
            'isCommentAllowed'      => 'boolean',
            'isPromoted'            => 'boolean',
            'isSticky'              => 'boolean',
            'isActive'              => 'boolean',
            'publishedAt'           => 'date|date_format:Y-m-d H:i:s',
            'translations.langCode' => 'required|in:pl,en',
            'translations.title'    => 'required',
            'translations.teaser'   => '',
            'translations.body'     => ''
        ],
        'update' => [
            'parentId'         => 'numeric',
            'weight'           => 'numeric',
            'isActive'         => 'boolean',
            'isOnHome'         => 'boolean',
            'isCommentAllowed' => 'boolean',
            'isPromoted'       => 'boolean',
            'isSticky'         => 'boolean',
            'publishedAt'      => 'date|date_format:Y-m-d H:i:s',
        ]
    ];

    /**
     * @var array
     */
    protected $filters = [
        'translations.title' => 'trim'
    ];
}
