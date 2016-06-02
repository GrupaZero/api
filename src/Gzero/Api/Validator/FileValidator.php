<?php namespace Gzero\Api\Validator;

use Gzero\Validator\AbstractValidator;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class FileValidator
 *
 * @package    Gzero\Api\Validator
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class FileValidator extends AbstractValidator {

    /**
     * @var array
     */
    protected $rules = [
        'list'   => [
            'lang'     => 'required_with:sort|in:pl,en,de,fr',
            'page'     => 'numeric',
            'perPage'  => 'numeric',
            'type'     => 'in:image,document,video,music',
            'isActive' => 'boolean',
            'sort'     => ''
        ],
        'create' => [
            'type'                     => 'required|in:image,document,video,music',
            'file'                     => '',
            'info'                     => '',
            'createdBy'                => '',
            'isActive'                 => 'boolean',
            'translations.langCode'    => 'required_with:translations.title|in:pl,en,de,fr',
            'translations.title'       => 'required_with:translations.langCode',
            'translations.description' => '',
        ],
        'update' => [
            'info'      => '',
            'isActive'  => 'boolean',
        ]
    ];

    /**
     * @var array
     */
    protected $filters = [
        'translations.title' => 'trim'
    ];
}
