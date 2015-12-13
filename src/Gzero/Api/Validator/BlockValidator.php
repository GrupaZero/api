<?php namespace Gzero\Api\Validator;

use Gzero\Validator\AbstractValidator;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class BlockValidator
 *
 * @package    Gzero\Api\Validator
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class BlockValidator extends AbstractValidator {

    /**
     * @var array
     */
    protected $rules = [
        'list'        => [
            'lang'     => 'required_with:sort|in:pl,en,de,fr',
            'page'     => 'numeric',
            'perPage'  => 'numeric',
            'type'     => 'in:basic,menu,slider,content,widget',
            'isActive' => 'boolean',
            'sort'     => '',
            'level'    => '',
            'trashed'  => ''
        ],
        'listContent' => [],
        'create'      => [
            'type'                  => 'required|in:basic,menu,slider,content,widget',
            'region'                => '',
            'weight'                => 'numeric',
            'filter'                => '',
            'options'               => '',
            'widget'                => '',
            'isCacheable'           => 'boolean',
            'isActive'              => 'boolean',
            'translations.langCode' => 'required|in:pl,en,de,fr',
            'translations.title'    => '',
            'translations.body'     => '',
        ],
        'update'      => [
            'region'      => '',
            'weight'      => 'numeric',
            'filter'      => '',
            'options'     => '',
            'widget'      => '',
            'isCacheable' => 'boolean',
            'isActive'    => 'boolean',
        ]
    ];

    /**
     * @var array
     */
    protected $filters = [
        'translations.title' => 'trim'
    ];
}
