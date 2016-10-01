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
        $url  = $file->getUrl();
        $file = $this->entityToArray(File::class, $file);
        return [
            'id'        => (int) $file['id'],
            'type'      => $file['type'],
            'name'      => $file['name'],
            'extension' => $file['extension'],
            'size'      => (int) $file['size'],
            'mimeType'  => $file['mimeType'],
            'info'      => $file['info'],
            'url'       => $url,
            'isActive'  => (bool) $file['isActive'],
            'weight'    => $this->setPivotNullableValue($file, 'weight'),
            'createdBy' => (int) $file['createdBy'],
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

    /**
     * Returns integer value or null
     *
     * @param int $value to evaluate
     *
     * @return int|null
     */
    private function setNullableValue($value)
    {
        return ($value !== null) ? (int) $value : null;
    }

    /**
     * Returns pivot integer value or null
     *
     * @param array  $file file to check for pivot
     * @param string $key  to evaluate
     *
     * @return int|null
     */
    private function setPivotNullableValue($file, $key)
    {
        if (array_key_exists('pivot', $file)) {
            return $this->setNullableValue($file['pivot'][$key]);
        }

        return null;
    }
}
