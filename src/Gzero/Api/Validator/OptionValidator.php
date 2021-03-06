<?php namespace Gzero\Api\Validator;

use Gzero\Validator\AbstractValidator;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class OptionValidator
 *
 * @package    Gzero\Api\Validator
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class OptionValidator extends AbstractValidator {

    /**
     * @var array
     */
    protected $rules = [
        'update' => [
            'key'   => ['required', 'exists:options,key'],
            'value' => 'required'
        ]
    ];

}
