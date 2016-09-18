<?php namespace Gzero\Api\Validator;

use Gzero\Validator\AbstractValidator;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class BlockFileValidator
 *
 * @package    Gzero\Api\Validator
 */
class BlockFileValidator extends AbstractValidator {

    /**
     * @var array
     */
    protected $rules = [
        'list'   => [
            'langCode' => 'in:pl,en,de,fr',
            'page'     => 'numeric',
            'perPage'  => 'numeric',
            'isActive' => 'boolean',
            'sort'     => ''
        ],
        'create' => [
            'filesIds' => 'required'
        ],
        'update' => [
            'weight' => '',
        ],
        'delete' => [
            'filesIds' => 'required'
        ]
    ];
}
