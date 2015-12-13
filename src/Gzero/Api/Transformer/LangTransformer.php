<?php namespace Gzero\Api\Transformer;

use Gzero\Entity\Lang;

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
class LangTransformer extends AbstractTransformer {

    /**
     * Transforms lang entity
     *
     * @param Lang|array $lang Lang entity
     *
     * @return array
     */
    public function transform($lang)
    {
        $lang = $this->entityToArray(Lang::class, $lang);
        return [
            'code'      => $lang['code'],
            'i18n'      => $lang['i18n'],
            'isEnabled' => (bool) $lang['isEnabled'],
            'isDefault' => (bool) $lang['isDefault']
        ];
    }
}
