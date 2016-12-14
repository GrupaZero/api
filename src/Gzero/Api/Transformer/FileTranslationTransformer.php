<?php namespace Gzero\Api\Transformer;

use Gzero\Entity\FileTranslation;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class FileTranslationTransformer
 *
 * @package    Gzero\Api\Transformer
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class FileTranslationTransformer extends AbstractTransformer {

    /**
     * Transforms route translation entity
     *
     * @param FileTranslation|array $translation FileTranslation entity
     *
     * @return array
     */
    public function transform($translation)
    {
        $translation = $this->entityToArray(FileTranslation::class, $translation);
        return [
            'id'          => (int) $translation['id'],
            'langCode'    => $translation['lang_code'],
            'title'       => $translation['title'],
            'description' => $translation['description'],
            'createdAt'   => $translation['created_at'],
            'updatedAt'   => $translation['updated_at'],
        ];
    }
}
