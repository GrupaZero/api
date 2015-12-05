<?php namespace Gzero\Api\Transformer;

use Gzero\Entity\BlockTranslation;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class BlockTranslationTransformer
 *
 * @package    Gzero\Api\Transformer
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class BlockTranslationTransformer extends AbstractTransformer {

    /**
     * Transforms block translation entity
     *
     * @param BlockTranslation|array $translation BlockTranslation entity
     *
     * @return array
     */
    public function transform($translation)
    {
        $translation = $this->entityToArray(BlockTranslation::class, $translation);
        return [
            'id'        => (int) $translation['id'],
            'lang'      => $translation['langCode'],
            'title'     => $translation['title'],
            'body'      => $translation['body'],
            'isActive'  => (int) $translation['isActive'],
            'createdAt' => $translation['createdAt'],
            'updatedAt' => $translation['updatedAt'],
        ];
    }
}
