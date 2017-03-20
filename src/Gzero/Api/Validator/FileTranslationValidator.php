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
class FileTranslationValidator extends AbstractValidator {

    /**
     * @var array
     */
    protected $rules = [
        'create' => [
            'lang_code'   => 'required|in:pl,en,de,fr',
            'title'       => 'required',
            'description' => ''
        ]
    ];

    /**
     * @var array
     */
    protected $filters = [
        'title'       => 'trim',
        'description' => 'trim'
    ];
}
