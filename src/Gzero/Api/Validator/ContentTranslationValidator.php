<?php namespace Gzero\Api\Validator;

use Gzero\Validator\AbstractValidator;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class ContentTranslationValidator
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
            'lang_code' => 'in:pl,en,de,fr',
            'page'     => 'numeric',
            'per_page'  => 'numeric',
            'is_active' => 'boolean',
            'sort'     => '',
            'level'    => ''
        ],
        'create' => [
            'lang_code'       => 'required|in:pl,en,de,fr',
            'is_active'       => '',
            'title'          => 'required',
            'teaser'         => '',
            'body'           => '',
            'seo_title'       => '',
            'seo_description' => '',
        ]
    ];

    /**
     * @var array
     */
    protected $filters = [
        'title'          => 'trim',
        'seo_title'       => 'trim',
        'seo_description' => 'trim'
    ];
}
