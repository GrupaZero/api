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
        $url = $file->getUrl();
        $file = $this->entityToArray(File::class, $file);
        return [
            'id'        => (int) $file['id'],
            'type'      => $file['type'],
            'name'      => $file['name'],
            'extension' => $file['extension'],
            'size'      => $file['size'],
            'mimeType'  => $file['mimeType'],
            'info'      => $file['info'],
            'url'       => $url,
            'isActive'  => (bool) $file['isActive'],
            'createdBy' => $file['createdBy'],
            'createdAt' => $file['createdAt'],
            'updatedAt' => $file['updatedAt']
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
