<?php namespace Gzero\Api\Transformer;

use Gzero\Model\Lang;
use League\Fractal\TransformerAbstract;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class LangTransformer
 *
 * @package    Gzero\Api\Transformer
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class LangTransformer extends TransformerAbstract {

    /**
     * Transforms content entity
     *
     * @param Lang|Array $lang Content entity
     *
     * @throws \Exception Test
     * @return array
     */
    public function transform($lang)
    {
        if (is_object($lang) && $lang instanceof Lang) {
            $lang = $lang->toArray();
        }
        return [
            'code'      => $lang['code'],
            'i18n'      => $lang['i18n'],
            'isEnabled' => (bool) $lang['isEnabled'],
            'isDefault' => (bool) $lang['isDefault']
        ];
    }
}
