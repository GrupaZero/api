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
            'langCode'       => $translation['lang_code'],
            'title'          => $translation['title'],
            'teaser'         => $translation['teaser'],
            'body'           => $translation['body'],
            'seoTitle'       => $translation['seo_title'],
            'seoDescription' => $translation['seo_description'],
            'isActive'       => (bool) $translation['is_active'],
            'createdAt'      => $translation['created_at'],
            'updatedAt'      => $translation['updated_at'],
        ];
    }
}
