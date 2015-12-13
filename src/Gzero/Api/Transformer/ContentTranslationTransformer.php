<?php namespace Gzero\Api\Transformer;

use Gzero\Entity\ContentTranslation;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class ContentTranslationTransformer
 *
 * @package    Gzero\Api\Transformer
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class ContentTranslationTransformer extends AbstractTransformer {

    /**
     * Transforms content translation entity
     *
     * @param ContentTranslation|array $translation ContentTranslation entity
     *
     * @return array
     */
    public function transform($translation)
    {
        $translation = $this->entityToArray(ContentTranslation::class, $translation);
        return [
            'id'             => (int) $translation['id'],
            'langCode'       => $translation['langCode'],
            'title'          => $translation['title'],
            'teaser'         => $translation['teaser'],
            'body'           => $translation['body'],
            'seoTitle'       => $translation['seoTitle'],
            'seoDescription' => $translation['seoDescription'],
            'isActive'       => (bool) $translation['isActive'],
            'createdAt'      => $translation['createdAt'],
            'updatedAt'      => $translation['updatedAt'],
        ];
    }
}
