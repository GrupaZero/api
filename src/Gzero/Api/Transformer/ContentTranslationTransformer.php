<?php namespace Gzero\Api\Transformer;

use Gzero\Entity\ContentTranslation;
use League\Fractal\TransformerAbstract;

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
class ContentTranslationTransformer extends TransformerAbstract {

    /**
     * Transforms content entity
     *
     * @param ContentTranslation|Array $translation Content entity
     *
     * @throws \Exception Test
     * @return array
     */
    public function transform($translation)
    {
        if (is_object($translation) && get_class($translation) == '\Gzero\Model\ContentTranslation') {
            $translation = $translation->toArray();
        }
        return [
            'id'        => $translation['id'],
            'lang'      => $translation['langCode'],
            'title'     => $translation['title'],
            'body'      => $translation['body'],
            'isActive'  => $translation['isActive'],
            'createdAt' => $translation['createdAt'],
            'updatedAt' => $translation['updatedAt'],
        ];
    }
}
