<?php namespace Gzero\Api\Transformer;

use Gzero\Entity\File;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class FileTransformer
 *
 * @package    Gzero\Api\Transformer
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class FileTransformer extends AbstractTransformer {

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'translations'
    ];

    /**
     * Transforms file entity
     *
     * @param File|array $file file entity
     *
     * @return array
     */
    public function transform($file)
    {
        $thumb = null;

        if ($file->type === 'image') {
            $width  = config('gzero.image.thumb.width');
            $height = config('gzero.image.thumb.height');
            $thumb  = croppaUrl($file->getFullPath(), $width, $height);
        }

        $file = $this->entityToArray(File::class, $file);
        return [
            'id'        => (int) $file['id'],
            'type'      => $file['type'],
            'name'      => $file['name'],
            'extension' => $file['extension'],
            'size'      => (int) $file['size'],
            'mimeType'  => $file['mime_type'],
            'info'      => $file['info'],
            'thumb'     => $thumb,
            'isActive'  => (bool) $file['is_active'],
            'createdBy' => (int) $file['created_by'],
            'createdAt' => $file['created_at'],
            'updatedAt' => $file['updated_at']
        ];
    }

    /**
     * Include Translations
     *
     * @param File $file Translation
     *
     * @return \League\Fractal\ItemResource
     */
    public function includeTranslations($file)
    {
        $translations = $file->translations;
        return $this->collection($translations, new FileTranslationTransformer());
    }
}
