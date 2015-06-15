<?php namespace Gzero\Api\Transformer;

use Gzero\Entity\RouteTranslation;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class RouteTranslationTransformer
 *
 * @package    Gzero\Api\Transformer
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class RouteTranslationTransformer extends AbstractTransformer {

    /**
     * Transforms content entity
     *
     * @param RouteTranslation|Array $translation Content entity
     *
     * @throws \Exception Test
     * @return array
     */
    public function transform($translation)
    {
        $translation = $this->entityToArray('\Gzero\Entity\RouteTranslation', $translation);
        return [
            'id'        => (int) $translation['id'],
            'lang'      => $translation['langCode'], // TODO: remove this line after updating admin package to use langCode field
            'langCode'  => $translation['langCode'],
            'url'       => $translation['url'],
            'isActive'  => (int) $translation['isActive'],
            'createdAt' => $translation['createdAt'],
            'updatedAt' => $translation['updatedAt'],
        ];
    }
}
