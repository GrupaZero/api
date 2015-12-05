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
     * Transforms route translation entity
     *
     * @param RouteTranslation|array $translation RouteTranslation entity
     *
     * @return array
     */
    public function transform($translation)
    {
        $translation = $this->entityToArray(RouteTranslation::class, $translation);
        return [
            'id'        => (int) $translation['id'],
            'lang'      => $translation['langCode'],
            'url'       => $translation['url'],
            'isActive'  => (int) $translation['isActive'],
            'createdAt' => $translation['createdAt'],
            'updatedAt' => $translation['updatedAt'],
        ];
    }
}
