<?php namespace Gzero\Api\Transformer;

use Gzero\Entity\Route;

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
class RouteTransformer extends AbstractTransformer {

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'translations'
    ];

    /**
     * Transforms content entity
     *
     * @param Route|Array $route Content entity
     *
     * @throws \Exception Test
     * @return array
     */
    public function transform($route)
    {
        $route = $this->entityToArray('\Gzero\Entity\Route', $route);
        return [
            'id'        => (int) $route['id'],
            'createdAt' => $route['createdAt'],
            'updatedAt' => $route['updatedAt']
        ];
    }

    /**
     * Include Translations
     *
     * @param Route $route Translation
     *
     * @return League\Fractal\ItemResource
     */
    public function includeTranslations($route)
    {
        $translations = $route->translations;
        return $this->collection($translations, new RouteTranslationTransformer());
    }
}
