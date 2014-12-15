<?php namespace Gzero\Api\Transformer;

use Gzero\Entity\Content;

/**
 * This file is part of the GZERO CMS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Class ContentTransformer
 *
 * @package    Gzero\Api\Transformer
 * @author     Adrian Skierniewski <adrian.skierniewski@gmail.com>
 * @copyright  Copyright (c) 2014, Adrian Skierniewski
 */
class ContentTransformer extends AbstractTransformer {

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'route',
        'translations'
    ];

    /**
     * Transforms content entity
     *
     * @param Content|Array $content Content entity
     *
     * @throws \Exception Test
     * @return array
     */
    public function transform($content)
    {
        $content = $this->entityToArray('\Gzero\Entity\Content', $content);
        return [
            'id'        => (int) $content['id'],
            'type'      => $content['type'],
            'weight'    => (int) $content['weight'],
            'isActive'  => (bool) $content['isActive'],
            'path'      => $this->buildPath($content['path']),
            'createdAt' => $content['createdAt'],
            'updatedAt' => $content['updatedAt']
        ];
    }

    /**
     * Include Translations
     *
     * @param Content $content Translation
     *
     * @return \League\Fractal\ItemResource
     */
    public function includeTranslations(Content $content)
    {
        $translations = $content->translations;
        return $this->collection($translations, new ContentTranslationTransformer());
    }

    /**
     * Include Translations
     *
     * @param Content $content Translation
     *
     * @return \League\Fractal\ItemResource
     */
    public function includeRoute(Content $content)
    {
        $route = $content->route;
        return (!empty($route)) ? $this->item($route, new RouteTransformer()) : null;
    }

    /**
     * Returns array of path ids as integers
     *
     * @param Content $path path to explode
     *
     * @return Array extracted path
     */
    private function buildPath($path)
    {
        $result = [];
        foreach (explode('/', $path) as $value) {
            if (!empty($value)) {
                $result[] = (int) $value;
            }
        }
        return $result;
    }
}
